<?php declare(strict_types=1);

namespace Ellipse\Middleware\Exceptions;

use TypeError;

use Psr\Http\Server\MiddlewareInterface;

use Ellipse\Exceptions\TypeErrorMessage;

class MiddlewareTypeException extends TypeError implements MiddlewareExceptionInterface
{
    public function __construct($value)
    {
        $msg = new TypeErrorMessage('middleware', $value, MiddlewareInterface::class);

        parent::__construct((string) $msg);
    }
}
