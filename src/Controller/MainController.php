<?php

namespace App\Controller;

use App\Entity\SyncBag;
use App\Entity\SyncData;
use App\Entity\SyncItem;
use App\Form\EasilyParsedDataType;
use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function upload(Request $request){
        $data = new SyncData();

        $form = $this->createForm(EasilyParsedDataType::class, $data);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Create entity manager
            $em = $this->getDoctrine()->getManager();

            //Generate necessary values for the provided dataset
            $time = new DateTime();
            $data->setCreated($time);
            $uuid = Uuid::uuid4();
            $data->setDataID($uuid);
            $data->setStatus("0");
            //Persist the data
            $em->persist($data);

            //Generate item to store the data in
            $item = new SyncItem();
            $uuid = Uuid::uuid4();
            $item->setItemID($uuid->toString());
            $item->setCurrentData($data);
            $item->setGrade();
            $item->setSyncBag("Unidentified");

            //Persist the item and push into the database
            $em->persist($item);
            $em->flush();
        }

        // entity manager
        // return a response

        return $this->render('main/upload.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
