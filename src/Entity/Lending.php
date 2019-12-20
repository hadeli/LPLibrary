<?php

namespace Alexandrie\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

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
     * @var DateTime|null
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var DateTime|null
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
     * @var integer|null
     *
     * @ORM\Column(name="copy_id", type="integer")
     */
    private $copy_id;

    /**
     * @var Reader
     *
     * @ORM\ManyToOne(targetEntity="Reader",cascade={"remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
     * })
     */
    private $reader;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="reader_id", type="integer")
     */
    private $reader_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime|null $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTime|null $endDate
     */
    public function setEndDate($endDate): void
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

    /**
     * @return int|null
     */
    public function getCopyId()
    {
        return $this->copy_id;
    }

    /**
     * @param int|null $copy_id
     */
    public function setCopyId(int $copy_id): void
    {
        $this->copy_id = $copy_id;
    }

    /**
     * @return int|null
     */
    public function getReaderId()
    {
        return $this->reader_id;
    }

    /**
     * @param int|null $reader_id
     */
    public function setReaderId(int $reader_id): void
    {
        $this->reader_id = $reader_id;
    }
}
