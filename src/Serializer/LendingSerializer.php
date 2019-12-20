<?php


namespace Alexandrie\Serializer;

use Alexandrie\Entity\Lending;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }

    /**
     * @param Lending $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            'id' => $object->getId(),
            'copy_id' => $object->getCopyId(),
            'startDate' => $object->getStartDate(),
            'endDate' => $object->getEndDate(),
            'reader_id' => $object->getReaderId(),
        );
    }
}