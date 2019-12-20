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
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $book_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $library_id;


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
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * @return mixed
     */
    public function getLibraryId()
    {
        return $this->library_id;
    }
}