<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 25.05.2018
 * Time: 14:17
 */

namespace Framework\Template\Php\Extension;


use Framework\Route\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{

	/**
	 * @var Router
	 */
	private $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('path', [$this, 'generatePath']),
		];
	}

	public function generatePath($name, array $params = [])
	{
		return $this->router->generate($name, $params);
	}
}