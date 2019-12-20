<?php


namespace Alexandrie\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reader
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\ReaderRepository")
 */
class Reader {

    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id()
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firtName;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;
    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

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
    public function getFirtName()
    {
        return $this->firtName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $firtName
     */
    public function setFirtName($firtName): void
    {
        $this->firtName = $firtName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


}