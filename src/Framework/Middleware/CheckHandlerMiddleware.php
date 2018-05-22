<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 21.05.2018
 * Time: 17:04
 */

namespace Framework\Middleware;


use Framework\Route\MiddlewareResolver;
use Framework\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

class CheckHandlerMiddleware implements MiddlewareInterface
{

    private $router, $resolver;

    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $result = $this->router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            $action = $this->resolver->resolve($result->getHandler());
            return $action->process($request, $handler);
        } catch (RuntimeException $e) {}

        return $handler->handle($request);
    }
}