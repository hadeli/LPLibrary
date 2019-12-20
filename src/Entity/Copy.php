<?php

namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CopyRepository")
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
     * @ORM\Column(type="integer", length=11)
     * @ORM\OneToMany(targetEntity="Book", mappedBy="id")
     */
    private $book_id;

    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\OneToMany(targetEntity="Library", mappedBy="id")
     */
    private $library_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): self
    {
        $this->book_id = $book_id;

        return $this;
    }

    public function getLibraryId(): ?int
    {
        return $this->library_id;
    }

    public function setLibraryId(int $library_id): self
    {
        $this->library_id = $library_id;

        return $this;
    }
}
