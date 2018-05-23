<?php
namespace App\Middleware;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction
{

    private $render;

    public function __construct(TemplateRenderer $render)
    {
        $this->render = $render;
    }

    public function __invoke(ServerRequestInterface $request)
    {
	    $username = $request->getAttribute('X-User');
        return new HtmlResponse($this->render->render('app/cabinet', [
            'username' => $username,
        ]));
    }
}