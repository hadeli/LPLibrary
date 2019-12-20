<?php

namespace App\Entity;

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
     * @var \Copy
     *
     * @ORM\ManyToOne(targetEntity="Copy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="copy_id", referencedColumnName="id")
     * })
     */
    private $copy;

    /**
     * @var \Reader
     *
     * @ORM\ManyToOne(targetEntity="Reader")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
     * })
     */
    private $reader;


}
