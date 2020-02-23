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
     * @ORM\ManyToOne(targetEntity="App\Entity\SyncItem", inversedBy="historyData", cascade={"persist"})
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

    public function gradeData(int $dataToGrade){

        switch($dataToGrade){
            case(0):
                if($this->getDataString0() == null || $this->getDataString0() == "") {
                    //If the data is missing, give the dataString an F grade.
                    return 'F';
                }elseif(preg_match("/^(http:\/\/|https:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/", $this->getDataString0()) == 0){
                    //RegEx match for URLs found on https://stackoverflow.com/questions/3809401/what-is-a-good-regular-expression-to-match-a-url
                    //If there is data but it's not a URL, give the dataString a D grade
                    return 'D';
                }else{
                    //If the data is a URL, give the dataString an A grade
                    return 'A';
                }
                break;
            case(1):
                if($this->getDataString1() == null || $this->getDataString1() == ""){
                    //If the data is missing, give the dataString an F grade.
                    return 'F';
                }elseif (strtotime($this->getDataString1()) == false){
                    //If the data is not time-interpretable, give the dataString a C grade.
                    return 'C';
                }else{
                    //If the data is time-interpretable, give the dataString an A grade.
                    return 'A';
                }
                break;
            case(2):
                if($this->getDataString2() == null || $this->getDataString2() == "") {
                    //If the data is missing, give the dataString a B grade.
                    return 'B';
                }elseif(preg_match("/.*/", $this->getDataString2()) == 0){
                    //If the data is not a string of printable characters, give the data a B grade.
                    return 'B';
                }else{
                    //If the data is a string of printable characters, give the data a A grade.
                    return 'A';
                }
                break;
            case(3):
                if($this->getDataString3() == null || $this->getDataString3() == "") {
                    //If the data is missing, give the dataString an F grade.
                    return 'F';
                }elseif(preg_match("/[0-9]\s*[0-9]\s*[0-9]\s*[0-9]\s*[a-zA-Z]\s*[a-zA-Z]\s*/", $this->getDataString3()) == 0){
                    //If the data is not a postal code, give the dataString a D grade.
                    return 'C';
                }else{
                    //If the data is a postal code, give the dataString an A grade.
                    return 'A';
                }
                break;
            case(4):
                if($this->getDataString4() == null || $this->getDataString4() == "") {
                    //If the data is missing, give the dataString a B grade.
                    return 'B';
                }elseif(preg_match("/.{5,40}/", $this->getDataString4()) == 0){
                    //If the data is not a string between 5-40 printable characters, give the data a B grade.
                    return 'B';
                }else{
                    //If the data is a string between 5-40 printable characters, give the data a A grade.
                    return 'A';
                }
                break;
            case(5):
                if($this->getDataString5() == null || $this->getDataString5() == "") {
                    //If the data is missing, give the dataString a B grade.
                    return 'B';
                }elseif(preg_match("/^[0-9]+\.?0*$/", $this->getDataString5()) == 0){
                    //If the data is not an integer or a float, give the dataString a B grade.
                    return 'B';
                }else{
                    //If the data is an integer or float, give the dataString an A grade.
                    return 'A';
                }
                break;

        }
    }

    public function getOverallGrade(){

        //Grade all data items individually
        for($i = 0; $i < 6; $i++){
            $grade[$i] = $this->gradeData($i);
        }
        //If the grade is 'F', mark the data as useless
        if(max($grade) == 'F'){
            $this->setStatus(-1);
        }

        //Return the 'maximum' grade, as per the ascii table, A < F, thus returns lowest overall grade.
        return max($grade);
    }
}
