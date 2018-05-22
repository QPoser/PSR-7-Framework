<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 19.05.2018
 * Time: 22:48
 */

namespace Framework\Route;


use Framework\Pipeline\InteropHandlerWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Zend\Stratigility\middleware;
use Zend\Stratigility\MiddlewarePipe;

class MiddlewareResolver
{

    public function resolve($handler): ?MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler)) {
            return middleware(function (ServerRequestInterface $request, RequestHandlerInterface $next) use ($handler) {
                $mware = $this->resolve(new $handler());
                return $mware->process($request, $next);
            });
        }

        if ($handler instanceof MiddlewareInterface) {
            return middleware(function (ServerRequestInterface $request, RequestHandlerInterface $next) use ($handler) {
                return $handler->process($request, $next);
            });
        }

        if (\is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (count($parameters) === 2 && $parameters[1]->isCallable()) {
                    return middleware(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                        return $handler($request, $next);
                    });
                }
                return middleware($handler);
            }
        }

        throw new \RuntimeException('Invalid type of handler');
    }

    private function createPipe(array $handlers): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }

}