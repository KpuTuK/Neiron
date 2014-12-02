<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\API\Kernel\ResponseInterface;
use Neiron\API\Kernel\Response\ResponseHeadersInterface;

/**
 * Класс для работы с выводом
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Response implements ResponseInterface
{
    /**
     * Строковое представение вывода
     * @var string
     */
    private $content;
    /**
     * Обьект класса ResponseHeaders
     * @var \Neiron\API\Kernel\Response\ResponseHeadersInterface 
     */
    private $headers = array();
    public function __construct(ResponseHeadersInterface $headers)
    {
        $this->headers = $headers;
    }
    /**
     * Перенаправляет пользователя по заданному url
     * @param string $url Url перенаправления
     */
    public function redirect($url)
    {
        $this->headers->headers('Location', $url);
        $this->headers->sendHeaders();
    }
    /**
     * Сохраняет выводит заголовки
     * @param mixed $name Массив заголовков или ключ заголовка
     * @param string $value Содержимое заголовка
     * @return mixed
     */
    public function headers($name = null, $value = null)
    {
        return $this->headers->headers($name, $value);
    }
    /**
     * Сохраняет содержимое вывода
     * @param string $content Строковое представение вывода
     * @return \Neiron\Kernel\Response
     */
    public function setContent($content)
    {
        $this->content .= (string) $content;
        return $this;
    }
    /**
     * Сохраняет заголовки и возвращает строковое представение вывода
     * @return string Строковое представение вывода
     */
    public function body()
    {
        $this->headers->sendHeaders();
        return $this->content;
    }
}