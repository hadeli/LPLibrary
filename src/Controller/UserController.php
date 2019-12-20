<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {

    function user($firstName, $lastName){
        $user = new User(1, $firstName,$lastName, new \DateTime('1964-02-12'), new \DateTime());

        return $this->json($user);
    }

}