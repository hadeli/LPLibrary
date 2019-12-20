<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Reader;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderNormalizer implements ContextAwareNormalizerInterface
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
            'birth_date' => $object->getBirthDate()->format('d/m/Y'),
            'email' => $object->getEmail(),
        ];
    }
}
