<?php declare(strict_types=1);

namespace Ellipse\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Handlers\RequestHandlerWithMiddlewareQueue;
use Ellipse\Handlers\Exceptions\MiddlewareTypeException as BaseMiddlewareTypeException;
use Ellipse\Middleware\Exceptions\MiddlewareTypeException;

class MiddlewareQueue implements MiddlewareInterface
{
    /**
     * Set up a middleware queue with the given middleware.
     *
     * @param array $middleware
     */
    public function __construct(array $middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * Create a request handler with middleware queue and proxy it.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {

            return (new RequestHandlerWithMiddlewareQueue($handler, $this->middleware))->handle($request);

        }

        catch (BaseMiddlewareTypeException $e) {

            throw new MiddlewareTypeException($e->value());

        }
    }
}
