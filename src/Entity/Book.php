<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class Book
 * @package Alexandrie\Entity
 * @Entity
 */
class Book
{
    /**
     * @var int
     * @Id
     * @Column(type="integer", length=11)
     * @GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @Column(type="string", length=200)
     */
    private $name;

    /**
     * @Column(type="string", length=15)
     */
    private $isbn;

    /**
     * @Column(type="integer", length=11)
     * @ManyToOne(targetEntity="Category", inversedBy="id")
     */
    private $category_id;

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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }
}