<?php
namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\RequestInterface;
/**
 * Description of Cookies
 *
 * @author KpuTuK
 */
class Cookies {
    private $cookies = array();
    private $fromHeader = array();
    public function __construct(RequestInterface $request) {
        $this->cookies = $request->globals('_COOKIE') ? 
            $request->globals('_COOKIE') : array();
    }
    /**
     * Сохраняет Cookie
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function set(
        $key,
        $value,
        $ttl = 0,
        $path = '/',
        $domain = null,
        $secure = null,
        $httpOnly = true
    ) {
        $this->fromHeader[] = array(
            'key' => $key,
            'value' => $value,
            'ttl' => time() + $ttl,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        );
        $this->cookies[$key] = $value;
    }
    public function get($key) {
        if (isset($this->cookies[$key])) {
            return $this->cookies[$key];
        }
        return false;
    }
    public function remove($key) {
        if (isset($this->cookies[$key])) {
            $this->set($key, '', -24*3600);
        }
    }
    public function getAll($fromHeaders = false) {
        if ($fromHeaders) {
            return $this->fromHeader;
        }
        return $this->cookies;
    }
}
