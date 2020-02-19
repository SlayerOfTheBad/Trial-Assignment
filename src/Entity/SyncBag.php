<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SyncBagRepository")
 */
class SyncBag
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
    private $bagID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SyncItem", mappedBy="syncBagRelation")
     */
    private $syncItems;

    public function __construct()
    {
        $this->syncItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBagID(): ?string
    {
        return $this->bagID;
    }

    public function setBagID(string $bagID): self
    {
        $this->bagID = $bagID;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection|SyncItem[]
     */
    public function getSyncItems(): Collection
    {
        return $this->syncItems;
    }

    public function addSyncItem(SyncItem $syncItem): self
    {
        if (!$this->syncItems->contains($syncItem)) {
            $this->syncItems[] = $syncItem;
            $syncItem->setSyncBagRelation($this);
        }

        return $this;
    }

    public function removeSyncItem(SyncItem $syncItem): self
    {
        if ($this->syncItems->contains($syncItem)) {
            $this->syncItems->removeElement($syncItem);
            // set the owning side to null (unless already changed)
            if ($syncItem->getSyncBagRelation() === $this) {
                $syncItem->setSyncBagRelation(null);
            }
        }

        return $this;
    }
}
