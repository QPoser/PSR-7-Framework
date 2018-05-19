<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 19.05.2018
 * Time: 19:50
 */

namespace Framework\Http;


use Prophecy\Exception\InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use SebastianBergmann\Timer\RuntimeException;

class Stream implements StreamInterface
{

    protected $resource;
    protected $stream;

    public function __construct($stream, $mode = 'r')
    {
        $this->setStream($stream, $mode);
    }

    public function __toString()
    {
        if (! $this->isReadable()) {
            return '';
        }

        try {
            if ($this->isSeekable()) {
                $this->rewind();
            }
        } catch (RuntimeException $e) {
            return '';
        }
    }

    public function close()
    {
        if (! $this->resource) {
            return;
        }

        $resource = $this->detach();
        fclose($resource);
    }

    public function detach()
    {
        $resource = $this->resource;
        $this->resource = null;
        return $resource;
    }

    public function attach($resource, $mode = 'r')
    {
        $this->setStream($resource, $mode);
    }

    public function getSize()
    {
        if (null === $this->resource) {
            return null;
        }

        $stats = fstat($this->resource);
        if ($stats !== false) {
            return $stats['size'];
        }

        return null;
    }

    public function tell()
    {
        if (! $this->resource) {
            throw new RuntimeException('No resource avaible; cannot tell position');
        }

        $result = ftell($this->resource);
        if (! is_int($result)) {
            throw new RuntimeException('Error occured during tell operation');
        }

        return $result;
    }

    public function eof()
    {
        if (! $this->resource) {
            return true;
        }

        return feof($this->resource);
    }

    public function isSeekable()
    {
        if (! $this->resource) {
            return false;
        }

        $meta = stream_get_meta_data($this->resource);
        return $meta['seekable'];
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        if (! $this->resource) {
            throw new RuntimeException('No resource available;');
        }

        if (! $this->isSeekable()) {
            throw new RuntimeException('Stream is not seekable');
        }

        $result = fseek($this->resource, $offset, $whence);

        if (0 !== $result) {
            throw new RuntimeException('Error seeking within stream');
        }

        return true;
    }

    public function rewind()
    {
        return $this->seek(0);
    }

    public function isWritable()
    {
        if (! $this->resource) {
            return false;
        }

        $meta = stream_get_meta_data($this->resource);
        $mode = $meta['mode'];

        return (
          strstr($mode, 'x')
            || strstr($mode, 'w')
            || strstr($mode, 'c')
            || strstr($mode, 'a')
            || strstr($mode, '+')
        );
    }

    public function write($string)
    {
        if (! $this->resource) {
            throw new RuntimeException('No resource available;');
        }

        if (! $this->isWritable()) {
            throw new RuntimeException('Stream is not writable');
        }

        $result = fwrite($this->resource, $string);

        if (false === $result) {
            throw new RuntimeException('Error writing to stream');
        }
        return $result;
    }

    public function isReadable()
    {
        if (! $this->resource) {
            return false;
        }

        $meta = stream_get_meta_data($this->resource);
        $mode = $meta['mode'];

        return (strstr($mode, 'r') || strstr($mode, '+'));
    }

    public function read($length)
    {
        if (! $this->resource) {
            throw new RuntimeException('No resource available;');
        }

        if (! $this->isReadable()) {
            throw new RuntimeException('Stream is not readable');
        }

        $result = fread($this->resource, $length);

        if (false === $result) {
            throw new RuntimeException('Error reading stream');
        }

        return $result;
    }

    public function getContents()
    {
        if (! $this->isReadable()) {
            throw new RuntimeException('Stream is not readable');
        }

        $result = stream_get_contents($this->resource);
        if (false === $result) {
            throw new RuntimeException('Error reading from stream');
        }
        return $result;
    }

    public function getMetadata($key = null)
    {
        if (null === $key) {
            return stream_get_meta_data($this->resource);
        }

        $metadata = stream_get_meta_data($this->resource);
        if (! array_key_exists($key, $metadata)) {
            return null;
        }

        return $metadata[$key];
    }

    private function setStream($stream, $mode = 'r')
    {
        $error = null;
        $resource = $stream;

        if (is_string($stream)) {
            set_error_handler(function ($e) use (&$error) {
                $error = $e;
            }, E_WARNING);
            $resource = fopen($stream, $mode);
            restore_error_handler();
        }

        if ($error) {
            throw new InvalidArgumentException(
                'Invalid steam provided.'
            );
        }

        if (! is_resource($resource) || 'stream' !== get_resource_type($resource)) {
            throw new InvalidArgumentException('Invalid stream provided.');
        }

        if ($stream !== $resource) {
            $this->stream = $stream;
        }

        $this->resource = $resource;
    }
}