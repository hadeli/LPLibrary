<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Library;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LibraryNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Library;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
        ];
    }
}
