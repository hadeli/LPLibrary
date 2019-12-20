<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
 */
class Lending
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id()
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $copyId;
    /**
     * @ORM\Column(type="integer")
     */
    private $readerId;
    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;
    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * Lending constructor.
     * @param $copyId
     * @param $readerId
     * @param $startDate
     * @param $endDate
     */
    public function __construct($copyId, $readerId, $startDate, $endDate)
    {
        $this->copyId = $copyId;
        $this->readerId = $readerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @param mixed $copyId
     */
    public function setCopyId($copyId): void
    {
        $this->copyId = $copyId;
    }

    /**
     * @param mixed $readerId
     */
    public function setReaderId($readerId): void
    {
        $this->readerId = $readerId;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCopyId()
    {
        return $this->copyId;
    }

    /**
     * @return mixed
     */
    public function getReaderId()
    {
        return $this->readerId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }


}