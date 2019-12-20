<?php


namespace Alexandrie\Services\Serializer;

use DateTime;
use Alexandrie\Entity\Reader;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ReaderSerializer implements ContextAwareNormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Reader;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $id = $object->getId();
        $fname = $object->getFirstName();
        $lname = $object->getLastName();
        $birthDate = $object->getBirthDate()->format('Y-m-d');
        $email = $object->getEmail();

        return array(
            "id" => $id,
            "nom" => $fname . ' ' . $lname,
            "né le" => $birthDate,
            'mail' => $email
        );
    }
}