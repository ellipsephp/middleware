# Middleware stack and queue

This package provides [Psr-15](https://www.php-fig.org/psr/psr-15/) middleware stack and queue, allowing to group multiple middleware together.

**Require** php >= 7.0

**Installation** `composer require ellipse/middleware`

**Run tests** `./vendor/bin/kahlan`

- [Middleware stack](https://github.com/ellipsephp/middleware#middleware-stack)
- [Middleware queue](https://github.com/ellipsephp/middleware#middleware-queue)

## Middleware stack

This package provides an `Ellipse\Middleware\MiddlewareStack` class allowing create a middleware processing the request with many middleware in LIFO order.

```php
<?php

namespace App;

use Ellipse\Middleware\MiddlewareStack;

// create Psr-15 middleware and request handler.
$middleware1 = new SomeMiddleware1;
$middleware2 = new SomeMiddleware2;
$handler = new SomeHandler;

// Create a middleware stack.
$stack = new MiddlewareStack([$middleware2, $middleware1]);

// The request goes through middleware1, middleware2, then hit the request handler.
$response = $stack->process($request, $handler);
```

## Middleware queue

This package provides an `Ellipse\Middleware\MiddlewareQueue` class allowing create a middleware processing the request with many middleware in FIFO order.

```php
<?php

namespace App;

use Ellipse\Middleware\MiddlewareQueue;

// create Psr-15 middleware and request handler.
$middleware1 = new SomeMiddleware1;
$middleware2 = new SomeMiddleware2;
$handler = new SomeHandler;

// Create a middleware queue.
$queue = new MiddlewareQueue([$middleware1, $middleware2]);

// The request goes through middleware1, middleware2, then hit the request handler.
$response = $queue->process($request, $handler);
```
