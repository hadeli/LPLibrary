<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $label;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

}