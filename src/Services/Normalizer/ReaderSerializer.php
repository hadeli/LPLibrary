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

    /**
     * {@inheritdoc}
     *
     * @param array $context options that normalizers have access to
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param Reader $reader Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool|\ArrayObject|null \ArrayObject is used to make sure an empty object is encoded as an object not an array
     *
     * @throws InvalidArgumentException   Occurs when the object given is not a supported type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     * @throws ExceptionInterface         Occurs for all the other cases of errors
     */
    public function normalize($reader, string $format = null, array $context = [])
    {
        return [
            "id" => $reader->getId(),
            "first_name" => $reader->getFirstName(),
            "last_name" => $reader->getLastName(),
            "birth_date" => $reader->getBirthDate(),
            "email" => $reader->getEmail()
        ];
    }
}