<?php

namespace App\Entity;


class User {

    public int $id;
    public string $firstName, $lastName;
    public \DateTime $birthDate, $updatedAt;

    public function __construct($id, $firstName, $lastName, $birthDate, $updatedAt){
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->updatedAt = $updatedAt;
    }
}