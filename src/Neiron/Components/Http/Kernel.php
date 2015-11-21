<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/

namespace Neiron\Components\Http;

/**
 * Обработчик HTTP
 * @author KpuTuK
 * @package Neiron framework
 * @category Http-component
 * @link
 */
class Kernel {
    /** 
     * Обработчик запросов к HTTP серверу
     * @var \Neiron\Components\Http\Request
     */
    protected $request;
    /** 
     * Обработчик ответов HTTP сервера
     * @var \Neiron\Components\Http\Response
     */
    protected $response;
    /**
     * Принимает указанный код и статус и возвращает тело сообщения в виде строки
     * @param int $code
     * @param string $reasonPhrase
     * @return string
     */
    public function getResponse($code = 200, $reasonPhrase = 'OK') {
        $cloned = clone $this;
        $cloned->response = $this->response->withStatus($code, $reasonPhrase);
        $this->sentHeaders();
        return $cloned->response->getBody()->getContents();
    }
    /**
     * Обработчик запросов к HTTP серверу
     * @return \Neiron\Components\Http\Request
     */
    public function getRequest() {
        return $this->request;
    }
    /**
     * Возвращает обьект класса реализующего \Psr\Http\Message\UriInterface
     * @return \Psr\Http\Message\UriInterface
     */
    public function getUri() {
        return $this->request->getUri();
    }
    /**
     * Возвращает клон класса с новым экземпляром
     *      обработчика запросов с указанными параметрами
     * @param string $uri
     * @param string $method
     * @param array $server
     * @param array $query
     * @param array $parsedBody
     * @param array $cookies
     * @param array $files
     * @return \Neiron\Components\Http\Kernel
     */
    public function withRequest(
        $uri = '/',
        $method = RequestMethodInterface::METH_GET,
        array $server = array(), 
        array $query = array(), 
        array $parsedBody = array(), 
        array $cookies = array(), 
        array $files = array()
    ) {
        $cloned = clone $this;
        $cloned->request = new Request(
            $uri,
            $method,
            $server,
            $query,
            $parsedBody,
            $cookies,
            $files
        );
        $cloned->response = new Response(200, 'OK', $this->request->getHeaders());
        return $cloned;
    }
    /**
     * Возвращает клон класса с новым экземпляром
     *      обработчика запросов с параметрами из $GLOBALS
     * @return \Neiron\Components\Http\Kernel
     */
    public function withRequestedFromGlobals() {
        if ( ! $this->request instanceof Request) {
            $this->request = new Request(
                $this->detectUri(), 
                $GLOBALS['_SERVER']['REQUEST_METHOD'],
                $GLOBALS['_SERVER'],
                $GLOBALS['_GET'],
                $GLOBALS['_POST'],
                $GLOBALS['_COOKIE'],
                $GLOBALS['_FILES']
            );
            $this->response = new Response(
                200, 'OK', $this->request->getHeaders()
            );
        }
        return clone $this;
    }
    /**
     * Возвращает клон класса с указаным контентом
     * @return \Neiron\Components\Http\Kernel
     */
    public function setContent($content = '', array $streamOptons = []) {
        $cloned = clone $this;
        $cloned->response = $this->response->withBody(
            new Stream($content, $streamOptons)
        );
        return $cloned;
    }
    /**
     * Сохраняет заголовки
     */
    protected function sentHeaders() {
        if ( ! headers_sent()) {
            foreach ($this->response->getHeaders() as $key => $value) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                header(
                    sprintf('%s: %s', $key, $value),
                    true,
                    $this->response->getStatusCode()
                );
            }
        }
    }
    /**
     * Определяет и возвращает uri
     * @return string
     */
    protected function detectUri() {
        if ( ! empty($GLOBALS['_SERVER']['PATH_INFO'])) {
            return $GLOBALS['_SERVER']['PATH_INFO'];
        } elseif ( ! empty($GLOBALS['_SERVER']['REQUEST_URI'])) {
            return explode('?', $GLOBALS['_SERVER']['REQUEST_URI'])[0];
        }
    }
}
