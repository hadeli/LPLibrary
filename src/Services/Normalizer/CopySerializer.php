<?php

namespace App\Service\Normalizer;


use App\Entity\Copy;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CopySerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Copy;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'book_id'=>$object->book_id,
            'library_id'=>$object->library_id
        );
    }
}