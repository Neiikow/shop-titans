<?php
namespace App\Bundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StrictIntegerHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'strict_integer',
                'method' => 'deserializeStrictIntegerFromJSON',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'strict_integer',
                'method' => 'serializeStrictIntegerToJSON',
            ],
        ];
    }

    public function deserializeStrictIntegerFromJSON(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        return $data;
    }

    public function serializeStrictIntegerToJSON(JsonSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        return $visitor->visitInteger($data, $type, $context);
    }
}