<?php


namespace Alexandrie\Services\Normalizer;

use Alexandrie\Entity\Reader;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    /**
     * @param Reader $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            "id" => $object->getId(),
            "firstname" => $object->getFirstName(),
            "lastname" => $object->getLastName(),
            "email" => $object->getEmail(),
            "birthdate" => $object->getBirthDate(),
        );
    }
}