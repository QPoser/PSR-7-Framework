<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 19.05.2018
 * Time: 22:00
 */

namespace Framework\Route;


use Psr\Http\Message\ServerRequestInterface;
use SebastianBergmann\Timer\RuntimeException;
use Zend\Diactoros\ServerRequestFactory;

interface Router
{
    /**
     * @param ServerRequestFactory $request
     * @throws RuntimeException
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result;

    /**
     * @param $name
     * @param array $params
     * @throws RuntimeException
     * @return string
     */
    public function generate($name, array $params): string;

}