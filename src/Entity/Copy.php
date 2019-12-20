<?php

namespace App\Entity;

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
     * @var \Book
     *
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * })
     */
    private $book;

    /**
     * @var \Library
     *
     * @ORM\ManyToOne(targetEntity="Library")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     * })
     */
    private $library;

    public function getId()
    {
        return $this->id;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }

    public function getLibrary()
    {
        return $this->library;
    }

    public function setLibrary($library)
    {
        $this->library = $library;

        return $this;
    }


}
