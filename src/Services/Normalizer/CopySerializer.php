<?php


namespace Alexandrie\Services\Normalizer;

use Alexandrie\Entity\Copy;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CopySerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Copy;
    }

    /**
     * @param Copy $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            "id" => $object->getId(),
            "book" =>  $object->getId(),
            "library" => $object->getLibrary()->getId(),
        );
    }
}