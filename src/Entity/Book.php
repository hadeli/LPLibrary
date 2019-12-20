<?php

namespace Alexandrie\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Book
 *
 * @ORM\Table(name="book", indexes={@ORM\Index(name="book_category_fk", columns={"category_id"})})
 * @ORM\Entity
 */
class Book
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="isbn", type="string", length=15, nullable=true)
     */
    private $isbn;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="category_id", type="integer")
     */
    private $category_id;


    /**
     * @ORM\OneToMany(targetEntity="Reader",mappedBy="book")
     */
    private $readers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    /**
     * @param string|null $isbn
     */
    public function setIsbn(?string $isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    /**
     * @param string|null $category_id
     */
    public function setCategoryId(string $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getReaders()
    {
        return $this->readers;
    }
}
