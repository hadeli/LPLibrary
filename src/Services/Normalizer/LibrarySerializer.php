<?php

namespace App\Service\Normalizer;


use App\Entity\Library;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LibrarySerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Library;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'name'=>$object->name,
        );
    }
}