<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
 */
class Copy
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id()
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $bookId;
    /**
     * @ORM\Column(type="integer")
     */
    private $libraryId;

    /**
     * Copy constructor.
     * @param $bookId
     * @param $libraryId
     */
    public function __construct($bookId, $libraryId)
    {
        $this->bookId = $bookId;
        $this->libraryId = $libraryId;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $bookId
     */
    public function setBookId($bookId): void
    {
        $this->bookId = $bookId;
    }

    /**
     * @param mixed $libraryId
     */
    public function setLibraryId($libraryId): void
    {
        $this->libraryId = $libraryId;
    }

    /**
     * @return mixed
     */
    public function getLibraryId()
    {
        return $this->libraryId;
    }


}