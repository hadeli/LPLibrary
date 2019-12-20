<?php


namespace Alexandrie\Services\Serializer;


use Alexandrie\Entity\Category;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CategorySerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Category;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $code = $object->getCode();
        $label = $object->getLabel();

        return array(
            "code" => $code,
            "label" => $label
        );
    }
}