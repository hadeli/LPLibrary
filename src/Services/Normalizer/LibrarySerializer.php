<?php


namespace Alexandrie\Services\Normalizer;


use Alexandrie\Entity\Library;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LibrarySerializer implements ContextAwareNormalizerInterface
{

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Library;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'name' => $object->getName(),
        ];
    }
}