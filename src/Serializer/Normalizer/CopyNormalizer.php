<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Copy;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CopyNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Copy;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'book' => $object->getBook()->getName(),
            'library' => $object->getLibrary()->getName(),
        ];
    }
}
