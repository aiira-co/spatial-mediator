<?php

namespace Spatial\MediatR;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Defines a mediator to encapsulate request/response and publishing interaction patterns
 */
interface IMediator extends MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(IRequest $request, IRequestHandler $handler): IResponse;






    // /**
    //  * Asynchronously send a notification to multiple handlers
    //  *
    //  * @param object $notification
    //  * @param CancellationToken $cancellationToken
    //  * @return void A task that represents the publish operation
    //  */
    // public function publish(object $notification, CancellationToken $cancellationToken = null);



    // /**
    //  * Asynchronously send a notification to multiple handlers
    //  *
    //  * @param TNotification $notification
    //  * @param CancellationToken $cancellationToken
    //  * @return void A task that represents the publish operation
    //  */
    // public function publish(TNotification $notification, CancellationToken $cancellationToken = null);
}
