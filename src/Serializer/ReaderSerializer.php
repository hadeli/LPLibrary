<?php


namespace Alexandrie\Serializer;

use Alexandrie\Entity\Reader;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    /**
     * @param Reader $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id' => $object->getId(),
            'firstName' => $object->getFirstName(),
            'lastName' => $object->getLastName(),
            'birthDate' => $object->getBirthDate(),
            'email' => $object->getEmail(),
        );
    }
}