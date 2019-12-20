<?php

namespace App\Service\Normalizer;


use App\Entity\Lending;
use \Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingSerializer implements ContextAwareNormalizerInterface{


    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }


    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id'=>$object->id,
            'copy_id'=>$object->copy_id,
            'reader_id'=>$object->reader_id,
            'start_date'=>$object->start_date,
            'end_date'=>$object->end_date
        );
    }
}