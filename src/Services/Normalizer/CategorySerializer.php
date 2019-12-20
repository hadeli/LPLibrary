<?php

namespace App\Service\Normalizer;


use App\Entity\Category;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CategorySerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Category;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'code'=>$object->code,
            'label'=>$object->label
        );
    }
}