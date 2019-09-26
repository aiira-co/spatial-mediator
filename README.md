# Spatial Mediator (http-server-middleware)

Simple PSR-7 PSR-15 http-server-middleware, unambitious mediator implementation in Spatial (PHP) Clean Architecture API.

### Installing MediatR

You should install [Mediator with Composer](https://www.nuget.org/packages/MediatR):

    composer require spatial/mediator

Requires PHP 7.1 or newer.

This libray is part of the Spatial API platform using Clean Architecture.
Its used to line the App's Logic from the controller, this way your Application independent on any framework.

### Usage

HTTP request handlers are a fundamental part of any web application. Server-side code receives a request message, processes it, and produces a response message. HTTP middleware is a way to move common request and response processing away from the application layer.

Spatial Mediator component MAY create and return a response without delegating to a request handler, if sufficient conditions are met.
If you are using Spatial WebApi Framework. then use the `mediator` to process from the controller to the main app in the Core\Logic\ namespace

```php
<?php
require '/path/to/vendor/autoload.php';

require 'vendor/autoload.php';

use Core\Logic\Test\GetProduct;
use Spatial\MediatR\Mediator;


$mediator = new Mediator();
$r = $mediator->process(new GetProduct); // returns a Response

// view result
echo $r->getBody()->getContent();

```

This is a PSR-15 implementation of the middleware, hence the `process()` method expects atleast 1 parameter: the request and (optiontally) the handler
if the second argument is not specified, the handler is generated using the namepace & class name of the request class.
Hence `Core\Logic\Test\GetProduct` ServerRequestInterface class autogenerate a `Core\Logic\Test\GetProductHanlder` as its RequestHandlerInterface

```php
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    class Mediator implements MiddlewareInterface{
        public function process(ServerRequestInterface $request, ?RequestHandlerInterface $handler=null): ResponseInterface
        {
            return $handler->handle($request);
        }
    }
```
