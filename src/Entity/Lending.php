<?php


namespace Alexandrie\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lending
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
 */
class Lending {

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
     * @ORM\Column(type="date")
     */
    private $startDate;
    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

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





}