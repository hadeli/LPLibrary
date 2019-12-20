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
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;
    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;
    /**
     * @ORM\Column(type="string", length=255)
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
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
}