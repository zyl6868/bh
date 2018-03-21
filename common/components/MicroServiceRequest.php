<?php
declare(strict_types = 1);
namespace common\components;

use Httpful\Request;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-13
 * Time: 下午6:31
 */
class MicroServiceRequest
{

    private $host;

    public function __construct($host)
    {
        $this->host = $host;

    }

    /**
     * @param $uri
     * @param null $mime
     * @return Request
     */
    public function get($uri, $mime = null)
    {
        return BanhaiRequest::get($uri, $mime)->addHeader('HOST', $this->host);
    }

    /**
     * @param $uri
     * @param null $payload
     * @param null $mime
     * @return Request
     */
    public function post($uri, $payload = null, $mime = null)
    {
        return BanhaiRequest::post($uri, $payload, $mime)->addHeader('HOST', $this->host);
    }
}