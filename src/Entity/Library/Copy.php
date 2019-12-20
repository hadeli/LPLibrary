<?php


namespace Alexandrie\Entity\Library;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
 */
class Copy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=11))
     */
    private $id;

    /**
     * @ORM\Column(name="book_id", type="integer", length=11))
     */
    private $book_id;

    /**
     * @ORM\Column(name="library_id", type="integer", length=11))
     */
    private $library_id;

    /**
     * Copy constructor.
     */
    public function __construct()
    {
    }

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