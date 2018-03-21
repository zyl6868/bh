<?php
namespace common\components;


use whitemerry\phpkin\AnnotationBlock;
use whitemerry\phpkin\Endpoint;
use whitemerry\phpkin\Identifier\SpanIdentifier;
use whitemerry\phpkin\Logger\SimpleHttpLogger;
use whitemerry\phpkin\Metadata;
use whitemerry\phpkin\Sampler\PercentageSampler;
use whitemerry\phpkin\Span;
use whitemerry\phpkin\Tracer;
use whitemerry\phpkin\TracerInfo;
use whitemerry\phpkin\TracerProxy;
use Yii;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-8-15
 * Time: 下午5:57
 */
class ZipkinConfService
{

    private $spanIdentifier = null;
    private $annotationBlock = null;
    private $span = null;
    private $requestStartTimestamp = null;

    /**
     * 开始追踪
     */
    public function beginTrace(callable $callback)
    {
        try {
            /**
             * Here is place for your application logic, we are making request to example REST API
             */
            $this->requestStartTimestamp = zipkin_timestamp();
            $this->spanIdentifier = new SpanIdentifier();
            $headerArr = [
                'X-B3-TraceId' => TracerInfo::getTraceId(),
                'X-B3-SpanId' => (string)$this->spanIdentifier,
                'X-B3-ParentSpanId' => TracerInfo::getTraceSpanId(),
                'X-B3-Sampled' => (int)TracerInfo::isSampled()
            ];

            call_user_func($callback, $headerArr);
        } catch (\Exception $e) {
            Yii::error('zipkin :' . $e->getMessage());

        }

    }


    public static function init($serviceName)
    {

        $traceName = 'cli';
        $port = '80';

        $logger = new SimpleHttpLogger(['host' => Yii::$app->params['zipkinConf'], 'contextOptions' => ['http' => ['timeout' => 1]], 'muteErrors' => false]);
        /**
         * And create tracer object, if you want to have statically access just initialize TracerProxy
         * TracerProxy::init($tracer);
         */

        try {
            list($route, $params) = Yii::$app->request->resolve();
            $traceName = $route;
        } catch (\Exception $e) {

        }

        if (Yii::$app->request->getIsConsoleRequest()) {
            $port = '0';
        }

        $endpoint = new Endpoint($serviceName, '127.0.0.1', $port);

        //采样频率
        $sampler = new  PercentageSampler(['percents' => 50]);
        $tracer = new Tracer($traceName, $endpoint, $logger, $sampler);


        /**
         * Create logger to Zipkin, host is Zipkin's ip
         * Read more about loggers https://github.com/whitemerry/phpkin#why-do-i-prefer-filelogger
         *
         * Make sure host is available with http:// and port because SimpleHttpLogger does not throw error on failure
         * For debug purposes you can disable muteErrors
         */


        $tracer->setProfile(Tracer::FRONTEND);
        TracerProxy::init($tracer);
    }


    public static function allEnd()
    {
        try {
            TracerProxy::trace();
        } catch (\Exception $e) {

        }

    }


    /**
     * 结束追踪
     * @param string $serverName 服务名称
     * @param string $name span名称
     */
    public function endTrace($serverName, $name)
    {


        try {
            $serviceInfo = Yii::$app->params['microService'];
            $ip = '';
            $port = '';

            if (!empty($serviceInfo)) {
                $serviceInfoArr = explode(':', $serviceInfo);
                $ip = $serviceInfoArr[0];
                $port = $serviceInfoArr[1];
            }

            // Setup zipkin data for this request
            $endpoint = new Endpoint($serverName, $ip, $port);
            $this->annotationBlock = new AnnotationBlock($endpoint, $this->requestStartTimestamp);


            $metadata=null;
            if (!Yii::$app->request->getIsConsoleRequest()) {
                $metadata = new Metadata();
                $request = Yii::$app->request;

                $metadata->set('client.method', $request->getMethod());
                $metadata->set('client.url', $request->getUrl());
                $metadata->set('client.path', $request->getPathInfo());
                $metadata->set('client.host', $request->getHostInfo());
            }

            $this->span = new Span($this->spanIdentifier, $name, $this->annotationBlock,$metadata);
            // Add span to Zipkin
            TracerProxy::addSpan($this->span);
            /**
             * Send data to Zipkin! :)
             * You're done
             */
        } catch (\Exception $e) {
            Yii::error("zipkin :" . $e->getMessage());
        }

    }

}