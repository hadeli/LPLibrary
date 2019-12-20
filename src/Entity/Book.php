<?php

namespace Alexandrie\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\BookRepository")
 */
class Book {
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id()
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=15)
     */
    private $isbn;
    /**
     * @ORM\Column(type="integer")
     */
    private $categoryId;

    /**
     * Book constructor.
     * @param $name
     * @param $isbn
     * @param $categoryId
     */
    public function __construct($name, $isbn, $categoryId)
    {
        $this->name = $name;
        $this->isbn = $isbn;
        $this->categoryId = $categoryId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId): void
    {
        $this->categoryId = $categoryId;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }




}