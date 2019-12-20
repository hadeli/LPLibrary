<?php


namespace Alexandrie\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alexandrie\Repository\ReaderRepository")
 */
class Reader
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }




}