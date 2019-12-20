<?php


namespace Alexandrie\Services\Normalizer;

use Alexandrie\Entity\Category;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CategorySerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Category;
    }

    /**
     * @param Category $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            "id" => $object->getId(),
            "code" => $object->getCode(),
            "label" => $object->getLabel(),
        );
    }
}