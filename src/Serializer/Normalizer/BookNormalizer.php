<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Book;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BookNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Book;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'isbn' => $object->getIsbn(),
            'category_name' => $object->getCategory()->getLabel(),
        ];
    }
}
