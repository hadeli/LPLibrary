<?php


namespace Alexandrie\Services\Serializer;


use Alexandrie\Entity\Copy;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CopySerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Copy;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $book = $object->getBook()->getName();
        $library = $object->getLibrary()->getName();

        return array(
            "titre" => $book,
            "lieu" => $library
        );
    }
}