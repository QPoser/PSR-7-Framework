<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 21.05.2018
 * Time: 17:00
 */

namespace Framework\Middleware;


use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class NotFoundMiddleware implements MiddlewareInterface
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
        return new HtmlResponse($this->renderer->render('/error/404', [
        	'request' => $request,
        ]), 404);
    }
}