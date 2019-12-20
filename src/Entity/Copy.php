<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/** @Entity */
class Copy {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Book", inversedBy="Copy")
     */
    private $book_id;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Library", inversedBy="Copy")
     */
    private $library_id;

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