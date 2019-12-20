<?php


namespace Alexandrie\Services\Normalizer;


use Alexandrie\Entity\Lending;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingSerializer implements ContextAwareNormalizerInterface
{

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'copy_id' => $object->getCopyId(),
            'reader_id' => $object->getReaderId(),
            'start_date' => $object->getStartDate(),
            'end_date' => $object->getEndDate(),
        ];
    }
}