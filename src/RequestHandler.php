<?php
namespace Spatial\MediatR;

use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    public function handle(IRequest $request): IResponse
    {

    }
}
