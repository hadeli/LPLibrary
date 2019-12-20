<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Copy
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
 */
class Copy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $book_id;
    /**
     * @ORM\Column(type="integer")
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