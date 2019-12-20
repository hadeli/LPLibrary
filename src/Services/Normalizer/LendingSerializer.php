<?php


namespace Alexandrie\Services\Normalizer;

use Alexandrie\Entity\Lending;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingSerializer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }

    /**
     * @param Lending $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return array(
            "id" => $object->getId(),
            "copy" => $object->getCopy()->getId(),
            "reader" => $object->getReader()->getId(),
            "start_date" => $object->getStartDate(),
            "end_date" => $object->getEndDate(),
        );
    }

}