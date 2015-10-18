<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel\Http;

use Psr\Http\Message\StreamInterface;

/**
 * Description of Stream
 *
 * @author KpuTuK
 */
class Stream implements StreamInterface  {
    protected $options = [];
    protected $stream;
    protected $modes = [
        ['read'] => ['r+', 'r', 'w+', 'a+', 'x+', 'c+'],
        ['write'] => ['w', 'w+', 'r+', 'a', 'a+', 'x', 'x+', 'c', 'c+']
    ];
    protected $readable = false;
    protected $writable = false;
    protected $seekable = false;
    public function __construct($stream, array $options = []) {
        $this->withOptions($options);
        if (is_string($stream)) {
            $stream = fopen($stream, 'r+');
        }
        $this->stream = $stream;
        $mode = $this->getMetadata('mode');
        $this->readable = isset($this->modes['read'][$mode]);
        $this->writable = isset($this->modes['read'][$mode]);
    }
    public function withOptions(array $options) {
        $this->options = array_merge($this->options, $options);
        return $this;
    }
    public function __toString() {
        return $this->getContents();
    }

    public function close() {
        return fclose($this->stream);
    }

    public function detach() {
        $return = $this->stream;
        $this->close();
        return $return;
    }

    public function eof() {
        return feof($this->stream);
    }

    public function getContents() {
        return stream_get_contents($this->stream);
    }

    public function getMetadata($key = null) {
        return stream_get_meta_data($this->stream)[$key];
    }

    public function getSize() {
        return $this->getMetadata('size');
    }

    public function isReadable() {
        return $this->readable;
    }

    public function isSeekable() {
        return $this->seekable;
    }

    public function isWritable() {
        return $this->writable;
    }

    public function read($length) {
        fread($this->stream, $length);
    }

    public function rewind() {
        rewind($this->stream);
    }

    public function seek($offset, $whence = SEEK_SET) {
        $this->seekable = true;
        fseek($this->stream, $offset, $whence);
    }

    public function tell() {
        return ftell($this->stream);
    }

    public function write($string) {
        fwrite($this->stream, $string);
    }

}
