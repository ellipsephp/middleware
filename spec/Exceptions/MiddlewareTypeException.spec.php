<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Middleware\Exceptions\MiddlewareExceptionInterface;
use Ellipse\Middleware\Exceptions\MiddlewareTypeException;

describe('MiddlewareTypeException', function () {

    beforeEach(function () {

        $this->exception = new MiddlewareTypeException('invalid');

    });

    it('should extend TypeError', function () {

        expect($this->exception)->toBeAnInstanceOf(TypeError::class);

    });

    it('should implement MiddlewareExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(MiddlewareExceptionInterface::class);

    });

});
