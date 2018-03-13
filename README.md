# Middleware stack and queue

This package provides classes for [Psr-15](https://www.php-fig.org/psr/psr-15/) middleware stack and queue, allowing to group multiple middleware together.

**Require** php >= 7.0

**Installation** `composer require ellipse/middleware`

**Run tests** `./vendor/bin/kahlan`

- [Middleware stack](#middleware-stack)
- [Middleware queue](#middleware-queue)

## Middleware stack

This package provides an `Ellipse\Middleware\MiddlewareStack` class allowing create a middleware processing the request using many middleware in LIFO order.

```php
<?php

namespace App;

use Ellipse\Middleware\MiddlewareStack;

// Create a middleware stack. (LIFO order)
$stack = new MiddlewareStack([new SomeMiddleware2, new SomeMiddleware1]);

// The request goes through middleware1, middleware2, then hit the request handler.
$response = $stack->process($request, new SomeHandler);
```

## Middleware queue

This package provides an `Ellipse\Middleware\MiddlewareQueue` class allowing create a middleware processing the request using many middleware in FIFO order.

```php
<?php

namespace App;

use Ellipse\Middleware\MiddlewareQueue;

// Create a middleware queue. (FIFO order)
$queue = new MiddlewareQueue([new SomeMiddleware1, new SomeMiddleware2]);

// The request goes through middleware1, middleware2, then hit the request handler.
$response = $queue->process($request, new SomeHandler);
```
