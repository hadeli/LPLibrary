<?php

use Alexandrie\Entity\Library;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LibrarySerializer implements ContextAwareNormalizerInterface {

    /**
     * {@inheritdoc}
     *
     * @param array $context options that normalizers have access to
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        // TODO: Implement supportsNormalization() method.
        return $data instanceof Library;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param Library $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool|\ArrayObject|null \ArrayObject is used to make sure an empty object is encoded as an object not an array
     *
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException   Occurs when the object given is not a supported type for the normalizer
     * @throws \Symfony\Component\Serializer\Exception\CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws \Symfony\Component\Serializer\Exception\LogicException             Occurs when the normalizer is not called in an expected context
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface         Occurs for all the other cases of errors
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        // TODO: Implement normalize() method.
        return array(
            'id' => $object->getId(),
            'name' => $object->getName()
        );
    }
}