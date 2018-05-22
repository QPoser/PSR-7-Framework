<?php
namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AboutAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('ab');
        return new \Zend\Diactoros\Response\HtmlResponse('About.' . $id);
    }
}