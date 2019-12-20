<?php


namespace Alexandrie\Services\Serializer;


use Alexandrie\Entity\Book;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BookSerializer implements ContextAwareNormalizerInterface
{


    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Book;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $id = $object->getId();
        $name = $object->getName();
        $isbn = $object->getIsbn();
        $category = $object->getCategory()->getLabel();

        return array(
            "id" => $id,
            "titre" => $name,
            "isbn" => $isbn,
            "categorie" => $category
        );
    }
}