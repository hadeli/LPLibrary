<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
 */


class Copy
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $book_id;


    /**
     * @ORM\Column(type="integer")
     *
     * @var int
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
     * @return int
     */
    public function getBookId(): int
    {
        return $this->book_id;
    }

    /**
     * @param int $book_id
     */
    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    /**
     * @return int
     */
    public function getLibraryId(): int
    {
        return $this->library_id;
    }

    /**
     * @param int $library_id
     */
    public function setLibraryId(int $library_id): void
    {
        $this->library_id = $library_id;
    }

}