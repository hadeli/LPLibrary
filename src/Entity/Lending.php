<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alexandrie\Entity\Copy;
use Alexandrie\Entity\Reader;
/**
 * Lending
 *
 * @ORM\Table(name="lending", indexes={@ORM\Index(name="lending_user_fk", columns={"reader_id"}), @ORM\Index(name="lending_copy__fk", columns={"copy_id"})})
 * @ORM\Entity
 */
class Lending
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var Copy
     *
     * @ORM\ManyToOne(targetEntity="Copy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="copy_id", referencedColumnName="id")
     * })
     */
    private $copy;

    /**
     * @var Reader
     *
     * @ORM\ManyToOne(targetEntity="Reader")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
     * })
     */
    private $reader;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime|null $startDate
     */
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|null $endDate
     */
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return Copy
     */
    public function getCopy(): Copy
    {
        return $this->copy;
    }

    /**
     * @param Copy $copy
     */
    public function setCopy(Copy $copy): void
    {
        $this->copy = $copy;
    }

    /**
     * @return Reader
     */
    public function getReader(): Reader
    {
        return $this->reader;
    }

    /**
     * @param Reader $reader
     */
    public function setReader(Reader $reader): void
    {
        $this->reader = $reader;
    }



}
