<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 * @package Alexandrie\Entity
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\ReaderRepository")
 */
class Reader
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id()
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;
    /**
     * @ORM\Column(type="datetime")
     */
    private $birthDate;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * Reader constructor.
     * @param $firstName
     * @param $lastName
     * @param $birthDate
     * @param $email
     */
    public function __construct($firstName, $lastName, $birthDate, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->email = $email;
    }

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
    public function getFirstName()
    {
        return $this->firstName;
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
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
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

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
}