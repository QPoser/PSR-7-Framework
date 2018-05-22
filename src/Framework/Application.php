<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.05.2018
 * Time: 21:44
 */

namespace Framework;


use Framework\Route\MiddlewareResolver;
use Framework\Route\RouteData;
use Framework\Route\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\Stratigility\MiddlewarePipe;
use function Zend\Stratigility\path;

class Application
{
    private $pipe;
    /**
     * @var MiddlewareResolver
     */
    private $resolver;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var callable
     */
    private $default;

    public function __construct(MiddlewareResolver $resolver, Router $router)
    {
        $this->pipe = new MiddlewarePipe();
        $this->resolver = $resolver;
        $this->router = $router;
    }

    public function pipe($path = null, $middleware): void
    {
        if ($path != null) {
            $this->pipe->pipe(path($path, $this->resolver->resolve($middleware)));
        }
        $this->pipe->pipe($this->resolver->resolve($middleware));
    }

    private function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }
    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, $options);
    }
    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }
    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }
    public function put($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }
    public function patch($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }
    public function delete($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

    public function run(ServerRequestInterface $request)
    {
        return $this->pipe->handle($request);
    }

}