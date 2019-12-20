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
    private $bookId;
    /**
     * @ORM\Column(type="integer")
     */
    private $libraryId;

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
        return $this->bookId;
    }

    /**
     * @return mixed
     */
    public function getLibraryId()
    {
        return $this->libraryId;
    }

}