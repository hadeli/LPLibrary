<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
 */
class Lending
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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




}