<?php
/**
 * PHP 5.4 framework с открытым иходным кодом
 */

namespace Neiron\Components\Http;

use Psr\Http\Message\StreamInterface;

/**
 * Обработчик потока
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http-component
 */
class Stream implements StreamInterface {
    /**
     * Опции потока
     * @var array 
     */
    protected $options = [];
    /**
     * Поток
     * @var recourse 
     */
    protected $stream;
    /**
     * Режимы чтения записей
     * @var array
     */
    protected $modes = [
        'read' => ['r+', 'r', 'w+', 'a+', 'x+', 'c+'], 
        'write' => ['w', 'w+', 'r+', 'a', 'a+', 'x', 'x+', 'c', 'c+'],
    ];
    /**
     * Доступен ли поток для чтения
     * @var bool 
     */
    protected $readable = false;
    /**
     * Доступен ли поток для записи
     * @var bool 
     */
    protected $writable = false;
    /**
     * Доступен ли поток для поиска
     * @var bool 
     */
    protected $seekable = false;
    /**
     * Иницилизирует класс
     * @param mixed $stream Открытый поток или путь к файлу
     * @param array $options Опции потока
     */
    public function __construct($stream = 'php://input', array $options = []) {
        $this->withOptions($options);
        if (is_string($stream)) {
            $stream = fopen($stream, 'r+');
        }
        $this->stream = $stream;
        $mode = $this->getMetadata('mode');
        $this->readable = isset($this->modes['read'][$mode]);
        $this->writable = isset($this->modes['write'][$mode]);
    }
    /**
     * Возвращает клон потока с заданными оциями
     * @param array $options
     * @return \Neiron\Components\Http\Stream
     */
    public function withOptions(array $options) {
        $cloned = clone $this;
        $cloned->options = array_merge($this->options, $options);
        return $this;
    }
    /**
     * Считывает все данные от начала до конца из потока в строку.
     * @return string
     */
    public function __toString() {
        return $this->getContents();
    }
    /**
     * Закрывает поток и все основные ресурсы
     * @return void
     */
    public function close() {
        return fclose($this->stream);
    }
    /**
     * Отделяет все ресурсы из потока
     * @return recourse
     */
    public function detach() {
        $return = $this->stream;
        $this->close();
        return $return;
    }
    /**
     * Проверяет достигнут ли конец потока
     * @return bool
     */
    public function eof() {
        return feof($this->stream);
    }
    /**
     * Возвращает содержимое потока ввиде строки
     * @return string
     */
    public function getContents() {
        return (string)stream_get_contents($this->stream);
    }
    /**
     * Возвращает ассоциативный массив метаданных или значение по ключу
     * @param string $key
     * @return array|string
     */
    public function getMetadata($key = null) {
        return stream_get_meta_data($this->stream)[$key];
    }
    /**
     * Возвращает размер данных потока
     * @return string
     */
    public function getSize() {
        return (string)$this->getMetadata('size');
    }
    /**
     * Проверяет доступен ли поток для чтения
     * @return bool
     */
    public function isReadable() {
        return $this->readable;
    }
    /**
     * Проверяет доступен ли поиск по потоку
     * @return bool
     */
    public function isSeekable() {
        return $this->seekable;
    }
    /**
     * Проверяет доступен ли поток для записи
     * @return bool
     */
    public function isWritable() {
        return $this->writable;
    }
    /**
     * Читает заданное количество байт из потока и возврашает их ввиде строки
     * @param int $length
     * @return string
     */
    public function read($length) {
        return fread($this->stream, (int)$length);
    }
    /**
     * Перемещает указатель в начало потока
     */
    public function rewind() {
        rewind($this->stream);
    }
    /**
     * Устанавливает указатель на заданное смещение из опции $whence
     * @param int $offset
     * @param int $whence Эквивалентна опциям fseek() (SEEK_END, SEEK_CUT, SEEK_SET)
     */
    public function seek($offset, $whence = SEEK_SET) {
        $this->seekable = true;
        fseek($this->stream, (int)$offset, (int)$whence);
    }
    /**
     * Возвращает текущую позицию курсора
     * @return int
     */
    public function tell() {
        return ftell($this->stream);
    }
    /**
     * Записывает строку в поток
     * @param string $string
     */
    public function write($string) {
        fwrite($this->stream, $string);
    }

}
