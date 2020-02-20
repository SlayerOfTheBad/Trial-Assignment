<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="App\Entity\SyncData", mappedBy="syncItem")
     */
    private $historyData;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SyncBag", inversedBy="syncItems")
     * @ORM\JoinColumn(nullable=true)
     */
    private $syncBagRelation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SyncData", cascade={"persist", "remove"})
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

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

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

}
