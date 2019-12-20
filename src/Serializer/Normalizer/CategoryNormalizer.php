<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Category;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CategoryNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Category;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'code' => $object->getCode(),
            'label' => $object->getLabel(),
        ];
    }
}
