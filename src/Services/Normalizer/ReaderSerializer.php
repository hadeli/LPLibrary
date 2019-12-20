<?php

namespace App\Service\Normalizer;


use App\Entity\Reader;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'first_name'=>$object->first_name,
            'last_name'=>$object->last_name,
            'birth_date'=>$object->birth_date,
            'email'=>$object->email,
        );
    }
}