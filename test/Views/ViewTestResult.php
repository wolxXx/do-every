<?php

declare(strict_types=1);

namespace DoEveryAppTest\Views;

class ViewTestResult
{
    public function __construct(
        public $responseCode,
        public $responseBody,
        public $responseObject,
    )
    {

    }
}