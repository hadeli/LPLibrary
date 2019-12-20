<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
 * @ORM\Table(name="copy")
 */
class Copy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Alexandrie\Entity\Book")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book_id;

    /**
     * @ORM\ManyToOne(targetEntity="Alexandrie\Entity\Library")
     * @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     */
    private $library_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?Book
    {
        return $this->book_id;
    }

    public function setBookId(?Book $book_id): self
    {
        $this->book_id = $book_id;

        return $this;
    }

    public function getLibraryId(): ?Library
    {
        return $this->library_id;
    }

    public function setLibraryId(?Library $library_id): self
    {
        $this->library_id = $library_id;

        return $this;
    }
}
