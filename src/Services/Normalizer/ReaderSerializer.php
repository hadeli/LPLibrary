<?php


namespace Alexandrie\Services\Normalizer;


use Alexandrie\Entity\Reader;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface
{

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
            'birth_date' => $object->getBirthDate(),
            'email' => $object->getEmail(),
        ];
    }
}