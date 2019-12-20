<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class Copy
 * @package Alexandrie\Entity
 * @Entity
 */
class Copy
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
     * @ManyToOne(targetEntity="Book", inversedBy="id")
     */
    private $book_id;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Library", inversedBy="id")
     */
    private $library_id;

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
     * @return mixed
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * @param mixed $book_id
     */
    public function setBookId($book_id): void
    {
        $this->book_id = $book_id;
    }

    /**
     * @return mixed
     */
    public function getLibraryId()
    {
        return $this->library_id;
    }

    /**
     * @param mixed $library_id
     */
    public function setLibraryId($library_id): void
    {
        $this->library_id = $library_id;
    }
}