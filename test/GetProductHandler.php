<?php

namespace Core\Logic\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spatial\Psr7\Response;

class GetProductHandler implements RequestHandlerInterface
{
    function __construct()
    {
        $this->response = new Response();
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}
