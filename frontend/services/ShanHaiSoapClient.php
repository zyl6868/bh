<?php

namespace frontend\services;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-27
 * Time: 上午10:59
 */

use Camcima\Soap\Client;

/**
 * Class SchoolService
 */
class ShanHaiSoapClient extends Client
{


    public function __call($function_name, $arguments)
    {

        $shanHaiToken = new ShanHaiToken();
        $shanHaiToken->getData();
        if (isset($arguments[0])) {
            $arguments[0]['token'] = json_encode($shanHaiToken);
        }
        $proFirstime = microtime(true);

         $result= parent::__call($function_name, $arguments);

        \Yii::info($function_name.' '.(microtime(true)-$proFirstime),'service');

        return $result;
    }

    public function __construct($wsdl, array $options = array())
    {
        parent::__construct($wsdl, $options);
        if (YII_ENV_DEV) {
            $this->debug = true;
        }


    }

    protected function logCurlMessage($message, \DateTime $messageTimestamp)
    {

        $logMessage = '[' . $messageTimestamp->format('Y-m-d H:i:s') . "] ----------------------------------------------------------\n" . $message . "\n\n";
        \Yii::trace($logMessage,'soap');
    }
}