<?php

namespace common\components;

use Httpful\Bootstrap;
use Httpful\Exception\ConnectionErrorException;
use Httpful\Http;
use Httpful\Request;
use Httpful\Response;
use whitemerry\phpkin\TracerInfo;

/**
 * Clean, simple class for sending HTTP requests
 * in PHP.
 *
 * There is an emphasis of readability without loosing concise
 * syntax.  As such, you will notice that the library lends
 * itself very nicely to "chaining".  You will see several "alias"
 * methods: more readable method definitions that wrap
 * their more concise counterparts.  You will also notice
 * no public constructor.  This two adds to the readability
 * and "chainabilty" of the library.
 *
 * @author Nate Good <me@nategood.com>
 */
class BanhaiRequest extends Request
{
    // Template Request object
    /**
     * @var
     */
    private static $_template;

    /**
     * We made the constructor private to force the factory style.  This was
     * done to keep the syntax cleaner and better the support the idea of
     * "default templates".  Very basic and flexible as it is only intended
     * for internal use.
     * @param array $attrs hash of initial attribute values
     */
    private function __construct($attrs = null)
    {
        if (!is_array($attrs)) return;
        foreach ($attrs as $attr => $value) {
            $this->$attr = $value;
        }
    }


    /**
     * @param null $method
     * @param null $mime
     * @return Request
     */
    public static function init($method = null, $mime = null)
    {
        // Setup our handlers, can call it here as it's idempotent
        Bootstrap::init();

        // Setup the default template if need be
        if (!isset(self::$_template))
            self::_initializeDefaults();

        $request = new BanhaiRequest();
        return $request
            ->_setDefaults()
            ->method($method)
            ->sendsType($mime)
            ->expectsType($mime);
    }


    /**
     * This is the default template to use if no
     * template has been provided.  The template
     * tells the class which default values to use.
     * While there is a slight overhead for object
     * creation once per execution (not once per
     * Request instantiation), it promotes readability
     * and flexibility within the class.
     */
    private static function _initializeDefaults()
    {
        // This is the only place you will
        // see this constructor syntax.  It
        // is only done here to prevent infinite
        // recusion.  Do not use this syntax elsewhere.
        // It goes against the whole readability
        // and transparency idea.
        self::$_template = new BanhaiRequest(array('method' => Http::GET));

        // This is more like it...
        self::$_template
            ->withoutStrictSSL();
    }


    /**
     * Actually send off the request, and parse the response
     * @return string|associative array of parsed results
     * @throws ConnectionErrorException when unable to parse or communicate w server
     */
    public function send()
    {

        $serverName = 'microService';
        if (isset($this->headers['HOST'])) {
            $serverName = $this->headers['HOST'];
        }

        $iniConf = new ZipkinConfService();
        $iniConf->beginTrace(function ($headerArr) {
            if (!empty($headerArr)) {
                $this->addHeaders($headerArr);
            }
        });

        $responseData = parent::send();

        try {
            $url = parse_url($this->uri)['path'];
            $url = preg_replace("/\/\d+/", '/:id', $url);

            $iniConf->endTrace($serverName, $url);
        } catch (\Exception $e) {

        }


        return $responseData;
    }

    /**
     * Set the defaults on a newly instantiated object
     * Doesn't copy variables prefixed with _
     * @return Request this
     */
    private function _setDefaults()
    {
        if (!isset(self::$_template))
            self::_initializeDefaults();
        foreach (self::$_template as $k => $v) {
            if ($k[0] != '_')
                $this->$k = $v;
        }
        return $this;
    }

    /**
     * HTTP Method Get
     * @return Request
     * @param string $uri optional uri to use
     * @param string $mime expected
     */
    public static function get($uri, $mime = null)
    {
        return self::init(Http::GET)->uri($uri)->mime($mime);
    }


    /**
     * Like Request:::get, except that it sends off the request as well
     * returning a response
     * @return Response
     * @param string $uri optional uri to use
     * @param string $mime expected
     */
    public static function getQuick($uri, $mime = null)
    {
        return self::get($uri, $mime)->send();
    }

    /**
     * HTTP Method Post
     * @return Request
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     */
    public static function post($uri, $payload = null, $mime = null)
    {
        return self::init(Http::POST)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Put
     * @return Request
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     */
    public static function put($uri, $payload = null, $mime = null)
    {
        return self::init(Http::PUT)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Patch
     * @return Request
     * @param string $uri optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime MIME to use for Content-Type
     */
    public static function patch($uri, $payload = null, $mime = null)
    {
        return self::init(Http::PATCH)->uri($uri)->body($payload, $mime);
    }

    /**
     * HTTP Method Delete
     * @return Request
     * @param string $uri optional uri to use
     */
    public static function delete($uri, $mime = null)
    {
        return self::init(Http::DELETE)->uri($uri)->mime($mime);
    }

    /**
     * HTTP Method Head
     * @return Request
     * @param string $uri optional uri to use
     */
    public static function head($uri)
    {
        return self::init(Http::HEAD)->uri($uri);
    }

    /**
     * HTTP Method Options
     * @return Request
     * @param string $uri optional uri to use
     */
    public static function options($uri)
    {
        return self::init(Http::OPTIONS)->uri($uri);
    }
}
