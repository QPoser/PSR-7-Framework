<?php
namespace App\Middleware;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomeAction implements MiddlewareInterface
{

	/**
	 * @var TemplateRenderer
	 */
	private $renderer;

	public function __construct(TemplateRenderer $renderer)
	{
		$this->renderer = $renderer;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new \Zend\Diactoros\Response\HtmlResponse($this->renderer->render('app/home'));
    }
}