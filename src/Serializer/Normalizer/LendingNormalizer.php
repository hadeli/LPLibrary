<?php

namespace Alexandrie\Serializer\Normalizer;

use Alexandrie\Entity\Lending;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class LendingNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Lending;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'copy' => $object->getCopy()->getBook()->getName(),
            'reader' => "{$object->getReader()->getFirstName()} {$object->getReader()->getLastName()} ",
            'start_date' => $object->getStartDate()->format('d/m/Y'),
            'end_date' => $object->getEndDate() ? $object->getEndDate()->format('d/m/Y') : '01/01/2999',
        ];
    }
}
