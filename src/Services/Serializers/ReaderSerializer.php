<?php


namespace Alexandrie\Services\Serializers;


use App\Entity\Reader;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'firstName' => $object->getFirstName(),
            'lastName' => $object->getLastName(),
            'birthDate' => $object->getBirthDate(),
            'email' => $object->getEmail()
        );
    }
}