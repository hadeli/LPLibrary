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
     */
    private $id;

    /**
     * @ORM\Column(type="category_id", type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="book_id", type="integer")
     */
    private $book_id;

    /**
     * Copy constructor.
     * @param $id
     * @param $category_id
     * @param $book_id
     */
    public function __construct($id, $category_id, $book_id)
    {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->book_id = $book_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
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
    public function getId()
    {
        return $this->id;
    }




}