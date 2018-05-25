<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 25.05.2018
 * Time: 14:16
 */

namespace Framework\Template\Php;


abstract class Extension
{

	public function getFunctions(): array
	{
		return [];
	}
}