<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/

namespace Neiron\Components\Http;

use Psr\Http\Message\UploadedFileInterface;
/**
 * Класс представляющий файл загруженный через HTTP запрос
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category http
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
    /**
     * Возвращает имя файла на клиенте
     * @return string
     */
    public function getClientFilename() {
        return $this->clientFileName;
    }
    /**
     * Возвращает MIME тип файла
     * @return string
     */
    public function getClientMediaType() {
        return $this->clientMediaType;
    }
    /**
     * Возвращает код ошибки
     * @return int
     */
    public function getError() {
        return $this->error;
    }
    /**
     * Возвращает размер файла
     * @return int
     */
    public function getSize() {
        return $this->size;
    }
    /**
     * Возвращает обьект потока файла
     * @return \Neiron\Components\Http\Stream
     */
    public function getStream() {
        return new Stream($this->tempName);
    }
    /**
     * Перемещает файл по указанному пути
     * @param string $targetPath
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function moveTo($targetPath) {
        if ( ! is_dir($targetPath)) {
            throw new \InvalidArgumentException('Путь не существует!');
        }
        if (
            ( ! is_uploaded_file($this->tempName)) &&
            ( ! move_uploaded_file(
                $this->tempName, 
                $targetPath.$this->clientFileName
            ))
        ) {
            throw new \RuntimeException('Ошибка перемещения файла!');
        }
    }

}
