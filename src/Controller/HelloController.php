<?php

namespace App\Controller;

use \Symfony\Component\HttpFoundation\JsonResponse;

class HelloController{
    function helloAction(){
        return new JsonResponse([
            'prenom' => 'Lau'
        ]);
    }

    function numberAction($number){
        return new JsonResponse([
            'number' => $number
        ]);
    }

    function putAction(){
        return new JsonResponse([
            'metier' => 'graphiste'
        ]);
    }
}