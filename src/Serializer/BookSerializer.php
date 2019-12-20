<?php


namespace Alexandrie\Serializer;

use Alexandrie\Entity\Book;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BookSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
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
            'id' => $object->getId(),
            'category' => array(
                'id' => $object->getCategory()->getId(),
                'code' => $object->getCategory()->getCode(),
                'label' => $object->getCategory()->getLabel()
            ),
            'isbn' => $object->getIsbn(),
            'name' => $object->getName(),
        );
    }
}