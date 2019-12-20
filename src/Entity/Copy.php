<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Copy
 *
 * @ORM\Table(name="copy", indexes={@ORM\Index(name="copy_library_fk", columns={"library_id"}), @ORM\Index(name="copy_book_fk", columns={"book_id"})})
 * @ORM\Entity
 */
class Copy
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
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * })
     */
    private $book;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="book_id", type="integer")
     */
    private $book_id;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="library_id", type="integer")
     */
    private $library_id;

    /**
     * @var Library
     *
     * @ORM\ManyToOne(targetEntity=Library::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     * })
     */
    private $library;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     */
    public function setBook(Book $book): void
    {
        $this->book = $book;
    }

    /**
     * @return Library
     */
    public function getLibrary(): Library
    {
        return $this->library;
    }

    /**
     * @param Library $library
     */
    public function setLibrary(Library $library): void
    {
        $this->library = $library;
    }

    /**
     * @return int|null
     */
    public function getBookId(): int
    {
        return $this->book_id;
    }

    /**
     * @param int|null $book_id
     */
    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    /**
     * @return int|null
     */
    public function getLibraryId(): int
    {
        return $this->library_id;
    }

    /**
     * @param int|null $library_id
     */
    public function setLibraryId(int $library_id): void
    {
        $this->library_id = $library_id;
    }
}
