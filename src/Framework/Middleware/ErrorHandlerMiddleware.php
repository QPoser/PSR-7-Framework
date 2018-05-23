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

class ErrorHandlerMiddleware implements MiddlewareInterface
{

	/**
	 * @var TemplateRenderer
	 */
	private $renderer;
	/**
	 * @var bool
	 */
	private $debug;

	public function __construct($debug = false, TemplateRenderer $renderer)
	{
		$this->renderer = $renderer;
		$this->debug = $debug;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
        	return $handler->handle($request);
        } catch (\Throwable|\Exception $e) {
        	$view = $this->debug ? 'error/error-debug' : 'error/error';
        	return new HtmlResponse($this->renderer->render($view, [
        		'request' => $request,
		        'exception' => $e,
	        ]), $e->getCode() ?: 500);
        }
    }
}