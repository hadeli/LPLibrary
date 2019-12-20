<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\LendingRepository")
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
     * @ORM\JoinColumn(nullable=false)
     */
    private $copy;

    /**
     * @ORM\ManyToOne(targetEntity="Alexandrie\Entity\Reader")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reader;

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

    public function getCopy(): ?Copy
    {
        return $this->copy;
    }

    public function setCopy(Copy $copy): self
    {
        $this->copy = $copy;

        return $this;
    }

    public function getReader(): ?Reader
    {
        return $this->reader;
    }

    public function setReader(?Reader $reader): self
    {
        $this->reader = $reader;

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
