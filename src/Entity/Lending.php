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
    private $copy_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $reader_id;
    /**
     * @ORM\Column(type="date")
     */
    private $start_date;
    /**
     * @ORM\Column(type="date")
     */
    private $end_date;


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
        return $this->copy_id;
    }

    /**
     * @return mixed
     */
    public function getReaderId()
    {
        return $this->reader_id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

}