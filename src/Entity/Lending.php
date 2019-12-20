<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
 * @ORM\Table(name="lending")
 */
class Lending
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Alexandrie\Entity\Copy")
     * @ORM\JoinColumn(name="copy_id", referencedColumnName="id")
     */
    private $copy_id;

    /**
     * @ORM\ManyToOne(targetEntity="Alexandrie\Entity\Reader")
     * @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCopyId(): ?Copy
    {
        return $this->copy_id;
    }

    public function setCopyId(?Copy $copy_id): self
    {
        $this->copy_id = $copy_id;

        return $this;
    }

    public function getReaderId(): ?Reader
    {
        return $this->reader_id;
    }

    public function setReaderId(?Reader $reader_id): self
    {
        $this->reader_id = $reader_id;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }
}
