<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Middleware\MiddlewareStack;
use Ellipse\Middleware\Exceptions\MiddlewareTypeException;

describe('MiddlewareStack', function () {

    it('should implement MiddlewareInterface', function () {

        $test = new MiddlewareStack([]);

        expect($test)->toBeAnInstanceOf(MiddlewareInterface::class);

    });

    describe('->process()', function () {

        context('when the middleware stack is empty', function () {

            it('should handle the given request with the given request handler', function () {

                $request = mock(ServerRequestInterface::class)->get();
                $response = mock(ResponseInterface::class)->get();

                $handler = mock(RequestHandlerInterface::class);

                $handler->handle->with($request)->returns($response);

                $middleware = new MiddlewareStack([]);

                $test = $middleware->process($request, $handler->get());

                expect($test)->toBe($response);

            });

        });

        context('when the middleware stack is not empty', function () {

            context('when all middleware implements MiddlewareInterface', function () {

                it('should process the middleware as a stack then handle the given request with the given request handler', function () {

                    $request1 = mock(ServerRequestInterface::class);
                    $request2 = mock(ServerRequestInterface::class);
                    $request3 = mock(ServerRequestInterface::class);
                    $response1 = mock(ResponseInterface::class);
                    $response2 = mock(ResponseInterface::class);
                    $response3 = mock(ResponseInterface::class);

                    $handler = mock(RequestHandlerInterface::class);

                    $middleware1 = new class implements MiddlewareInterface
                    {
                        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
                        {
                            $request = $request->withAttribute('key1', 'value1');

                            $response = $handler->handle($request);

                            return $response->withHeader('key1', 'value1');
                        }
                    };

                    $middleware2 = new class implements MiddlewareInterface
                    {
                        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
                        {
                            $request = $request->withAttribute('key2', 'value2');

                            $response = $handler->handle($request);

                            return $response->withHeader('key2', 'value2');
                        }
                    };

                    $request1->withAttribute->with('key2', 'value2')->returns($request2);
                    $request2->withAttribute->with('key1', 'value1')->returns($request3);
                    $response1->withHeader->with('key1', 'value1')->returns($response2);
                    $response2->withHeader->with('key2', 'value2')->returns($response3);

                    $handler->handle->with($request3)->returns($response1);

                    $middleware = new MiddlewareStack([$middleware1, $middleware2]);

                    $test = $middleware->process($request1->get(), $handler->get());

                    expect($test)->toBe($response3->get());

                });

            });

            context('when a middleware does not implement MiddlewareInterface', function () {

                it('should throw a MiddlewareTypeException', function () {

                    $request = mock(ServerRequestInterface::class)->get();
                    $response = mock(ResponseInterface::class)->get();

                    $handler = mock(RequestHandlerInterface::class)->get();

                    $middleware = new MiddlewareStack([
                        mock(MiddlewareInterface::class)->get(),
                        'middleware',
                        mock(MiddlewareInterface::class)->get(),
                    ]);

                    $test = function () use ($middleware, $request, $handler) {

                        $middleware->process($request, $handler);

                    };

                    $exception = new MiddlewareTypeException('middleware');

                    expect($test)->toThrow($exception);

                });

            });

        });

    });

});
