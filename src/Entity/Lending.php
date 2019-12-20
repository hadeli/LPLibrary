<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class Lending
 * @package Alexandrie\Entity
 * @Entity
 */
class Lending
{
    /**
     * @var int
     * @Id
     * @Column(type="integer", length=11)
     * @GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Copy", inversedBy="id")
     */
    private $copy_id;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Reader", inversedBy="id")
     */
    private $reader_id;

    /**
     * @Column(type="date")
     */
    private $start_date;

    /**
     * @Column(type="date")
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