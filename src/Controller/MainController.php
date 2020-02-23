<?php

namespace App\Controller;

use App\Entity\SyncBag;
use App\Entity\SyncData;
use App\Entity\SyncItem;
use App\Form\EasilyParsedDataType;
use App\Repository\SyncDataRepository;
use App\Repository\SyncItemRepository;
use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/createSyncBag", name="createSyncBag")
     */

    //Unfinished function. Will make a SyncBag to store SyncItems in.

    public function createSyncBag(){
        $syncBag = new SyncBag();
        $uuid = Uuid::uuid4();
        $syncBag->setSource($uuid);
        $uuid = Uuid::uuid4();
        $syncBag->setBagID($uuid);

        $em = $this->getDoctrine()->getManager();

        $em->persist($syncBag);
        $em->flush();


        return $this->redirect("/upload");
    }


    /**
     * @Route("/upload", name="upload")
     */

    public function upload(Request $request, SyncItemRepository $syncItemRepository){
        $data = new SyncData();

        $form = $this->createForm(EasilyParsedDataType::class, $data);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Create entity manager
            $em = $this->getDoctrine()->getManager();


            //Generate necessary values for the provided dataset
            $time = new DateTime();
            $data->setCreated($time);
            if($data->getDataID() == null){
                //If no ID was specified, generate a custom uuid
                $uuid = Uuid::uuid4();
                $data->setDataID($uuid);
            }
            switch($data->getOverallGrade()){
                case('F'):
                    $data->setStatus(-1);
                    break;
                case('A'):
                    $data->setStatus(1);
                    break;
                default:
                    $data->setStatus(0);
            }
            //Persist the data
            $em->persist($data);

            //Generate item to store the data in
            $item = new SyncItem();
            $uuid = Uuid::uuid4();
            $item->setItemID($uuid->toString());
            $item->setCurrentData($data);
            $item->setGrade();
            $item->setSyncBag("Unidentified");
            $em->persist($item);

            //Check the database for SyncItems that have duplicate data IDs.
            if($item->getGrade() != 'F') {
                $database = $syncItemRepository->findAll();
                foreach ($database as $storedItem) {
                    if ($storedItem->getGrade() != 'F' && $storedItem->getCurrentData()->getDataID() == $item->getCurrentData()->getDataID()) {
                        //If a usable dataset with the same ID is found, grade both data sets and set the one with the highest grade as the master
                        if ($item->getGrade() >= $storedItem->getGrade()) {
                            //Stored item has a higher or equal grade, and is thus the master
                            $storedItem->mergeWith($item, $em);
                            $em->remove($item);
                        } else {
                            //New item has a higher grade, and is thus the master
                            $item->mergeWith($storedItem, $em);
                            //If the new item was the master, the old item is not necessary anymore as it has been merged, and can thus be removed.
                            $em->remove($storedItem);
                        }
                    }
                }
            }

            //Persist the additions and push into the database
            $em->flush();
        }

        // entity manager
        // return a response

        return $this->render('main/upload.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/dumpDatabase", name="dumpDatabase")
     */

    public function dumpDatabase(SyncDataRepository $SDR, SyncItemRepository $SIR){
        $dataList = $SDR->findAll();
        $itemList = $SIR->findAll();
        $em = $this->getDoctrine()->getManager();


        foreach($dataList as $oldData){
            if($oldData->getSyncItem() != null)
            $em->remove($oldData);
        }

        foreach($itemList as $oldData){
            $em->remove($oldData);
        }

        foreach($dataList as $oldData){
            if($oldData->getSyncItem() == null)
                $em->remove($oldData);
        }

        $em->flush();

        return $this->redirect("/upload");

    }
}
