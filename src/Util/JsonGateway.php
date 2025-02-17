<?php

namespace DoEveryApp\Util;

final class JsonGateway
{
    public static function Factory($data, \Psr\Http\Message\ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $jsonObject = \Laminas\Json\Json::encode(
            $data,
            true,
            ['silenceCyclicalExceptions' => true]
        );
        if (false === $jsonObject) {
            throw new \Exception(sprintf(
                'could not encode response to json (%s, %s)',
                json_last_error(),
                json_last_error_msg()
            ));
        }
        $jsonObject = \Laminas\Json\Json::prettyPrint($jsonObject, ['indent' => '  ']);
        $response
            ->getBody()
            ->write($jsonObject)
        ;

        return $response->withHeader('Content-Type', 'application/json');
    }
}
