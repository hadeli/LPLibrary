<?php


namespace Alexandrie\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lending
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
 */
class Lending
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCopyId()
    {
        return $this->copy_id;
    }

    /**
     * @param mixed $copy_id
     */
    public function setCopyId($copy_id): void
    {
        $this->copy_id = $copy_id;
    }

    /**
     * @return mixed
     */
    public function getReaderId()
    {
        return $this->reader_id;
    }

    /**
     * @param mixed $reader_id
     */
    public function setReaderId($reader_id): void
    {
        $this->reader_id = $reader_id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date): void
    {
        $this->end_date = $end_date;
    }
}