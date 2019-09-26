<?php

namespace Spatial\MediatR;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Mediator implements MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        if ($request == null) {
            throw new ArgumentNullException(get_class($request));
        }

        $handler = $handler ?? $this->_getHandlerName($request);

        return $handler->handler($request);
    }


    /**
     * Generate Hanlder name from request name
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    private function _getHandlerName(IRequest $request): IRequestHandler
    {
        $requestNamespace = explode('\\', get_class($request));
        if (count($requestNamespace) > 1) {
            $modelName = $requestNamespace[count($requestNamespace) - 1];
        } else {
            $modelName = $requestNamespace;
        }
        $handlerName = $modelName . 'Handler';
        $handler = \str_replace($modelName, $handlerName, get_class($request));
        return new $handler();
    }
}
