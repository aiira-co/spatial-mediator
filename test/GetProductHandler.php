<?php

namespace Core\Logic\Test;

use Spatial\MediatR\IRequest;
use Spatial\MediatR\IRequestHandler;
use Spatial\MediatR\Response;

class GetProductHandler implements IRequestHandler
{
    public function handle(IRequest $request): Response
    {
        return new Response();
    }
}
