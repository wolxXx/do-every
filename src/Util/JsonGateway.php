<?php

namespace DoEveryApp\Util;

final class JsonGateway
{
    public static function Factory($data, \Psr\Http\Message\ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $jsonObject = \Laminas\Json\Json::encode(
            valueToEncode: $data,
            cycleCheck: true,
            options: ['silenceCyclicalExceptions' => true]
        );
        if (false === $jsonObject) {
            throw new \Exception(message: sprintf(
                'could not encode response to json (%s, %s)',
                json_last_error(),
                json_last_error_msg()
            ));
        }
        $jsonObject = \Laminas\Json\Json::prettyPrint(json: $jsonObject, options: ['indent' => '  ']);
        $response
            ->getBody()
            ->write(string: $jsonObject)
        ;

        return $response->withHeader(name: 'Content-Type', value: 'application/json');
    }
}
