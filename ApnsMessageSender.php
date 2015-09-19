<?php
// https://github.com/immobiliare/ApnsPHP
require_once dirname(__FILE__).'/ApnsPHP_SJIS/ApnsPHP/Autoload.php';

class ApnsMessageSender
{
    private $pushSocket = null;

    private $pushMessage = null;

    private $deviceTokens = array();

    /**
     * @param string $environment ApnsPHP_Abstract::{ENVIRONMENT_SANDBOX, ENVIRONMENT_PRODUCTION}
     * @param filepath $providerCertificateFile
     * @param filepath $rootCertificationAuthority
     */
    public function __construct($environment, $providerCertificateFile, $rootCertificationAuthority)
    {
        $this->pushSocket = new ApnsPHP_Push($environment, $providerCertificateFile);
        $this->pushSocket->setRootCertificationAuthority($rootCertificationAuthority);
        $this->pushSocket->connect();
    }

    /**
     * @param array $tokens デバイストークン, 文字列の配列
     * @return $this
     */
    public function setDeviceTokens(array $tokens)
    {
        $this->deviceTokens = $tokens;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->pushMessage = mb_convert_encoding($message, "UTF-8", 'SJIS');;
        return $this;
    }

    /**
     *
     */
    public function send()
    {
        if (empty($this->pushMessage)) {
            throw new RuntimeException("push message is empty");
        }
        if (0 === count($this->deviceTokens)) {
            return;
        }
        foreach ($this->deviceTokens as $token) {
            $this->pushSocket->add(
                $this->createMessage($token, $this->pushMessage)
            );
        }
        $this->pushSocket->send();
    }

    /**
     * @param $deviceToken
     * @param $pushMessage
     * @return ApnsPHP_Message
     */
    private function createMessage($deviceToken, $pushMessage)
    {
        $message = new ApnsPHP_Message($deviceToken);
        $message->setText($pushMessage);
        $message->setExpiry(30);
        return $message;
    }

    function __destruct()
    {
        if (is_null($this->pushSocket)) {
            return;
        }
        $this->pushSocket->disconnect();
    }
}
