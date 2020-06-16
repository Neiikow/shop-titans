<?php
namespace App\Bundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StrictStringHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'strict_string',
                'method' => 'deserializeStrictStringFromJSON',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'strict_string',
                'method' => 'serializeStrictStringToJSON',
            ],
        ];
    }

    public function deserializeStrictStringFromJSON(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        return $data;
    }

    public function serializeStrictStringToJSON(JsonSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        return $visitor->visitString($data, $type, $context);
    }
}