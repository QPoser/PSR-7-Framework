<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 19.05.2018
 * Time: 19:27
 */

namespace Framework\Http;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use SebastianBergmann\Timer\RuntimeException;

class Request implements RequestInterface
{

    protected $uri, $method, $headers = [], $headerNames = [];

    private $protocol = '1.1', $stream;

    private function initialize($uri = null, $method = null, $body = 'php://memory', array $headers = [])
    {
        $this->guardMethod($method);

        $this->method = $method ?: '';
        $this->uri = $this->createUri($uri);
        $this->stream = $this->getStream($body, 'wb+');

        $this->setHeaders($headers);

        if (! $this->hasHeader('Host') && $this->uri->getHost()) {
            $this->headerNames['host'] = 'Host';
            $this->headers['Host'] = [$this->getHostFromUri()];
        }
    }

    private function createUri($uri)
    {

    }

    private function getStream($stream, $modeIfNotInstance)
    {
        if ($stream instanceof StreamInterface) {
            return $stream;
        }

        if (!is_string($stream) && !is_resource($stream)) {
            throw new RuntimeException('Stream must be a string param or resource');
        }

        return new Stream($stream, $modeIfNotInstance);
    }

    private function setHeaders(array $originalHeaders)
    {
        $headerNames = $headers = [];

        foreach ($originalHeaders as $header => $value) {
            $value = $this->filterHeaderValue($value);

            $this->assertHeader($header);

            $headerNames[strtolower($header)] = $header;
            $headers[$header] = $value;
        }

        $this->headerNames = $headerNames;
        $this->headers = $headers;
    }

    private function guardMethod($method)
    {
        if ($method === null) {
            return;
        }

        if (!is_string($method)) {
            throw new RuntimeException('Http method does not correct');
        }
    }

    public function __construct($uri = null, $method = null, $body = 'php://temp', array $headers = [])
    {
        $this->initialize($uri, $method, $body, $headers);
    }

    public function getProtocolVersion()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}