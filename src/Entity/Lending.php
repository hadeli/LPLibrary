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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $copy_id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $reader_id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $end_date;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCopyId(): int
    {
        return $this->copy_id;
    }

    /**
     * @param int $copy_id
     */
    public function setCopyId(int $copy_id): void
    {
        $this->copy_id = $copy_id;
    }

    /**
     * @return int
     */
    public function getReaderId(): int
    {
        return $this->reader_id;
    }

    /**
     * @param int $reader_id
     */
    public function setReaderId(int $reader_id): void
    {
        $this->reader_id = $reader_id;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->start_date;
    }

    /**
     * @param \DateTime $start_date
     */
    public function setStartDate(\DateTime $start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    /**
     * @param \DateTime $end_date
     */
    public function setEndDate(?\DateTime $end_date): void
    {
        $this->end_date = $end_date;
    }

}