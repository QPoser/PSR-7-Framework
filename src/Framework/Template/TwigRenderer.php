<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 25.05.2018
 * Time: 11:38
 */

namespace Framework\Template;


use Twig\Environment;

class TwigRenderer implements TemplateRenderer
{

	private $environment;
	private $extension;

	public function __construct(Environment $environment, $extension = '.html.twig')
	{
		$this->environment = $environment;
		$this->extension = $extension;
	}

	public function render($name, array $params = []): string
	{
		return $this->environment->render($name . $this->extension, $params);
	}
}