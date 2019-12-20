<?php


namespace Alexandrie\Services\Serializer;


use Alexandrie\Entity\Library;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LibrarySerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Library;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $id = $object->getId();
        $name = $object->getName();

        return array(
            "id" => $id,
            "nom" => $name
        );
    }

}