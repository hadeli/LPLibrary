<?php


namespace Alexandrie\Services\Serializers;


use App\Entity\Lending;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'startDate' => $object->getStartDate(),
            'endDate' => $object->getEndDate(),
            'copy' => $object->getCopy()->getId(),
            'reader' => $object->getReader()->getId()
        );
    }
}