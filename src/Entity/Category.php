<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
    */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @var String
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=100)
     * @var String
     */
    private $label;


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
     * @return String
     */
    public function getCode(): String
    {
        return $this->code;
    }

    /**
     * @param String $code
     */
    public function setCode(String $code): void
    {
        $this->code = $code;
    }

    /**
     * @return String
     */
    public function getLabel(): String
    {
        return $this->label;
    }

    /**
     * @param String $label
     */
    public function setLabel(String $label): void
    {
        $this->label = $label;
    }
}