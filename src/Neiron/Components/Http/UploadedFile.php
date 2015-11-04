<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Components\Http;
use Psr\Http\Message\UploadedFileInterface;
/**
 * Description of UploadedFile
 *
 * @author KpuTuK
 */
class UploadedFile implements UploadedFileInterface {
    protected $tempName;
    protected $clientFileName;
    protected $clientMediaType;
    protected $error;
    protected $size;
    public function __construct($data) {
        $this->tempName = $data['tmp_name'];
        $this->clientFileName = $data['name'];
        $this->clientMediaType = $data['type'];
        $this->error = $data['error'];
        $this->size = $data['size'];
    }
    public function getClientFilename() {
        return $this->clientFileName;
    }

    public function getClientMediaType() {
        return $this->clientMediaType;
    }

    public function getError() {
        return $this->error;
    }

    public function getSize() {
        return $this->size;
    }

    public function getStream() {
        return new Stream($this->tempName);
    }

    public function moveTo($targetPath) {
        if ( ! is_dir($targetPath)) {
            throw new \InvalidArgumentException('Путь не существует!');
        }
        if (
            ( ! is_uploaded_file($this->tempName))  &&
            ( ! move_uploaded_file(
                $this->tempName, 
                $targetPath . $this->clientFileName
            ))
        ) {
            throw new \RuntimeException('Ошибка перемещения файла!');
        }
    }

}
