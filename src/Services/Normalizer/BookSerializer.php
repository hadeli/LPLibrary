<?php

namespace App\Service\Normalizer;


use App\Entity\Book;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BookSerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Book;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'isbn'=>$object->isbn,
            'name'=>$object->name,
            'category_id'=>$object->category_id
        );
    }
}