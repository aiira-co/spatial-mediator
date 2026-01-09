<?php

declare(strict_types=1);

namespace Spatial\Mediator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spatial\Core\App;


//use Spatial\Entity\ReopeningEntityManager;

class Mediator implements MiddlewareInterface
{

    //    public function __construct(private ReopeningEntityManager $em)
    //    {
    //    }

    public ServerRequestInterface $request;


    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface|null $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface|null $handler = null): ResponseInterface
    {

        $request = $this->_cloneRequest($this->request, $request);

        $handler = $handler ?? $this->_getHandlerName($request);
        $response =  $handler->handle($request);
        return $response;
    }


    private function _cloneRequest(ServerRequestInterface $serverRequest, ServerRequestInterface $handlerRequest): ServerRequestInterface
    {
        try {


            // Copy core request data
            $handlerRequest = $handlerRequest
                ->withMethod($serverRequest->getMethod())
                ->withUri($serverRequest->getUri())
                ->withProtocolVersion($serverRequest->getProtocolVersion());

            // Copy headers
            foreach ($serverRequest->getHeaders() as $name => $values) {
                $handlerRequest = $handlerRequest->withHeader((string)$name, $values);
            }

            // Copy body
            $handlerRequest = $handlerRequest->withBody($serverRequest->getBody());

            // Copy server params
            foreach ($serverRequest->getServerParams() as $key => $value) {
                $handlerRequest = $handlerRequest->withAttribute($key, $value);
            }

            // Copy query params
            $handlerRequest = $handlerRequest->withQueryParams($serverRequest->getQueryParams());

            // Copy parsed body (e.g., JSON/form data)
            $handlerRequest = $handlerRequest->withParsedBody($serverRequest->getParsedBody());

            // Copy uploaded files
            $handlerRequest = $handlerRequest->withUploadedFiles($serverRequest->getUploadedFiles());

            // Copy custom attributes
            foreach ($serverRequest->getAttributes() as $key => $value) {
                $handlerRequest = $handlerRequest->withAttribute($key, $value);
            }

            return $handlerRequest;
        } catch (\Exception $e) {
            error_log('[Spatial\\Mediator] Error cloning request: ' . $e->getMessage());
        }
    }


    /**
     * Generate Handler name from request name
     *
     * @param ServerRequestInterface $request
     * @return RequestHandlerInterface
     */
    private function _getHandlerName(ServerRequestInterface $request): RequestHandlerInterface
    {
        $requestNamespace = explode('\\', get_class($request));
        if (count($requestNamespace) > 1) {
            $modelName = $requestNamespace[count($requestNamespace) - 1];
        } else {
            $modelName = $requestNamespace;
        }
        $handlerName = $modelName . 'Handler';
        $handler = \str_replace($modelName, $handlerName, get_class($request));
        return  App::$diContainer->get($handler);
    }
}
