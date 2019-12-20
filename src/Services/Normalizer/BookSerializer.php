<?php


namespace Alexandrie\Services\Normalizer;

use Alexandrie\Entity\Book;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BookSerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Book;
    }

    /**
     * @param Book $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            "id" => $object->getId(),
            "name" => $object->getName(),
            "isbn" => $object->getIsbn(),
            "category" => array(
                "id" => $object->getCategory()->getId(),
                "code" => $object->getCategory()->getCode(),
                "label" => $object->getCategory()->getLabel(),
            ),
        );
    }
}