<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 21.05.2018
 * Time: 19:15
 */

namespace Framework\Middleware;


use Framework\Route\MiddlewareResolver;
use Framework\Route\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchMiddleware implements MiddlewareInterface
{

    /**
     * @var MiddlewareResolver
     */
    private $resolver;

    public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$result = $request->getAttribute(Result::class)) {
            return $handler->handle($request);
        }
        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware->process($request, $handler);
    }
}