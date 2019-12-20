<?php


namespace Alexandrie\Services\Serializer;


use Alexandrie\Entity\Lending;
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
        $id = $object->getId();
        $start = $object->getStartDate();
        $end = $object->getEndDate();
        $copyBook = $object->getCopy()->getBook()->getName();
        $copyPlace = $object->getCopy()->getLibrary()->getName();
        $readerFName = $object->getReader()->getFirstName();
        $readerLName = $object->getReader()->getLastName();

        return array(
            "id" => $id,
            "nom" => $copyBook,
            "loué le" => $start,
            "à" => $copyPlace,
            "par" => $readerFName. ' ' . $readerLName,
            "jusqu\'au" => $end
        );
    }
}