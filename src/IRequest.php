<?php

namespace Spatial\MediatR;

use Psr\Http\Message\ServerRequestInterface;
/**
 * Marker interface to represent a request with a void response
 */
interface IRequest extends ServerRequestInterface
{ }

/// <summary>
/// Marker interface to represent a request with a response
/// </summary>
/// <typeparam name="TResponse">Response type</typeparam>
// interface IRequest<out TResponse> extends IBaseRequest { }

/// <summary>
/// Allows for generic type constraints of objects implementing IRequest or IRequest{TResponse}
/// </summary>
interface IBaseRequest
{ }
