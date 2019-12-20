<?php


namespace Alexandrie\Services\Serializers;


use App\Entity\Category;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
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
        return array(
            'code' => $object->getCode(),
            'label' => $object->getLabel()
        );
    }
}