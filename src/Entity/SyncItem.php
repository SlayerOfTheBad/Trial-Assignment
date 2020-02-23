<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SyncItemRepository")
 */
class SyncItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $syncBag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SyncData", mappedBy="syncItem", cascade={"persist"})
     */
    private $historyData;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SyncBag", inversedBy="syncItems", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $syncBagRelation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SyncData", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $current_data;


    public function __construct()
    {
        $this->historyData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemID(): ?string
    {
        return $this->itemID;
    }

    public function setItemID(string $itemID): self
    {
        $this->itemID = $itemID;

        return $this;
    }

    public function getSyncBag(): ?string
    {
        return $this->syncBag;
    }

    public function setSyncBag(string $syncBag): self
    {
        $this->syncBag = $syncBag;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(): self
    {
        $this->grade = $this->getCurrentData()->getOverallGrade();

        return $this;
    }



    /**
     * @return Collection|SyncData[]
     */
    public function getHistoryData(): Collection
    {
        return $this->historyData;
    }

    public function addHistoryData(SyncData $historyData): self
    {
        if (!$this->historyData->contains($historyData)) {
            $this->historyData[] = $historyData;
            $historyData->setSyncItem($this);
        }

        return $this;
    }

    public function removeHistoryData(SyncData $historyData): self
    {
        if ($this->historyData->contains($historyData)) {
            $this->historyData->removeElement($historyData);
            // set the owning side to null (unless already changed)
            if ($historyData->getSyncItem() === $this) {
                $historyData->setSyncItem(null);
            }
        }

        return $this;
    }

    public function getSyncBagRelation(): ?SyncBag
    {
        return $this->syncBagRelation;
    }

    public function setSyncBagRelation(?SyncBag $syncBagRelation): self
    {
        $this->syncBagRelation = $syncBagRelation;

        return $this;
    }

    public function getCurrentData(): ?SyncData
    {
        return $this->current_data;
    }

    public function setCurrentData(SyncData $current_data): self
    {
        $this->current_data = $current_data;

        return $this;
    }

    public function mergeWith(SyncItem $donor, ObjectManager $em){
        //collect data to make working with it easier.
        $masterData = $this->getCurrentData();
        $donorData = $donor->getCurrentData();

        //Duplicate the master's data so the master's data doesn't get altered in the history data
        $updateData = clone $masterData;

        //Add current data sets to the HistoryData
        $masterData->setStatus(-1);
        $donorData->setStatus(-1);
        $this->addHistoryData($masterData);
        $this->addHistoryData($donorData);

        //Add donor's history to the master's history
        $donorHistory = $donor->getHistoryData();
        foreach($donorHistory as $history){
            $this->addHistoryData($history);
        }


        //Compare the grades of the data in the master and the donor. If the donor has better data
        //Than the master at any point, transfer the data.
        //Would have been significantly easier with arrays. Impossible because the dataStrings are
        //stored as variables, rather than in a single array.

        if($donorData->getDataString0() != null &&
            $updateData->gradeData(0) > $donorData->gradeData(0)
        ){
            $updateData->setDataString0($donorData->getDataString0());
        }
        if($donorData->getDataString1() != null &&
            $updateData->gradeData(1) > $donorData->gradeData(1)
        ){
            $updateData->setDataString1($donorData->getDataString1());
        }
        if($donorData->getDataString2() != null &&
            $updateData->gradeData(2) > $donorData->gradeData(2)
        ){
            $updateData->setDataString2($donorData->getDataString2());
        }
        if($donorData->getDataString3() != null &&
            $updateData->gradeData(3) > $donorData->gradeData(3)
        ){
            $updateData->setDataString3($donorData->getDataString3());
        }
        if($donorData->getDataString4() != null &&
            $updateData->gradeData(4) > $donorData->gradeData(4)
        ){
            $updateData->setDataString4($donorData->getDataString4());
        }
        if($donorData->getDataString5() != null &&
            $updateData->gradeData(5) > $donorData->gradeData(5)
        ){
            $updateData->setDataString5($donorData->getDataString5());
        }

        //Set new time
        $time = new DateTime();
        $updateData->setCreated($time);

        //Set status of the data
        if($updateData->getOverallGrade() == 'A'){
            $updateData->setStatus(1);
        }else{
            $updateData->setStatus(0);
        }
        $em->persist($updateData);

        //Update the data and the grade of the master
        $this->setCurrentData($updateData);
        $this->setGrade();

        $em->persist($this);
    }

}
