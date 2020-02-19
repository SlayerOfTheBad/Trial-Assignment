<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SyncDataRepository")
 */
class SyncData
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
    private $DataID;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataString5;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SyncItem", inversedBy="historyData")
     */
    private $syncItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataID(): ?string
    {
        return $this->DataID;
    }

    public function setDataID(string $DataID): self
    {
        $this->DataID = $DataID;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getDataString0(): ?string
    {
        return $this->dataString0;
    }

    public function setDataString0(?string $dataString0): self
    {
        $this->dataString0 = $dataString0;

        return $this;
    }

    public function getDataString1(): ?string
    {
        return $this->dataString1;
    }

    public function setDataString1(string $dataString1): self
    {
        $this->dataString1 = $dataString1;

        return $this;
    }

    public function getDataString2(): ?string
    {
        return $this->dataString2;
    }

    public function setDataString2(?string $dataString2): self
    {
        $this->dataString2 = $dataString2;

        return $this;
    }

    public function getDataString3(): ?string
    {
        return $this->dataString3;
    }

    public function setDataString3(?string $dataString3): self
    {
        $this->dataString3 = $dataString3;

        return $this;
    }

    public function getDataString4(): ?string
    {
        return $this->dataString4;
    }

    public function setDataString4(?string $dataString4): self
    {
        $this->dataString4 = $dataString4;

        return $this;
    }

    public function getDataString5(): ?string
    {
        return $this->dataString5;
    }

    public function setDataString5(?string $dataString5): self
    {
        $this->dataString5 = $dataString5;

        return $this;
    }

    public function getSyncItem(): ?SyncItem
    {
        return $this->syncItem;
    }

    public function setSyncItem(?SyncItem $syncItem): self
    {
        $this->syncItem = $syncItem;

        return $this;
    }
}
