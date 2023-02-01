<?php

declare(strict_types=1);

namespace Social\Http;

use Social\Http\Handlers\IHttpRequestHandler;
use InvalidArgumentException;

class Route
{
    private string $method;
    private string $path;
    private string $requestHandlerClass;

    public function __construct(string $method, string $path, string $requestHandlerClass)
    {
        if (!in_array(IHttpRequestHandler::class, class_implements($requestHandlerClass), true)) {
            $errorMessage = "{$requestHandlerClass} doesn't implement " . IHttpRequestHandler::class;
            throw new InvalidArgumentException($errorMessage);
        }

        $this->method = $method;
        $this->path = $path;
        $this->requestHandlerClass = $requestHandlerClass;
    }

    public static function create(string $method, string $path, string $requestHandlerClass): Route
    {
        return new self($method, $path, $requestHandlerClass);
    }

    public static function createPost(string $path, string $requestHandlerClass): Route
    {
        return self::create('POST', $path, $requestHandlerClass);
    }

    public static function createGet(string $path, string $requestHandlerClass): Route
    {
        return self::create('GET', $path, $requestHandlerClass);
    }

    public function canHandle(string $method, string $path): bool
    {
        return $this->method === $method && $this->path === $path;
    }

    public function getHandler(): IHttpRequestHandler
    {
        return new $this->requestHandlerClass();
    }
}