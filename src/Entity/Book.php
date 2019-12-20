<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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