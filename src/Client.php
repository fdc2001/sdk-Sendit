<?php

namespace Filipeclemente\USendItSdk;

use Filipeclemente\USendItSdk\Response\ScheduleResponse;
use Filipeclemente\USendItSdk\Response\SmsResponse;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    /**
     * @var string
     */
    private $username = '',$password = '';
    /**
     * @var string|Integer
     */
    private $sender = null;

    private $productionUrl = 'https://api.usendit.pt/v2/remoteusendit.asmx';
    private $sandboxUrl = 'https://apitest.usendit.pt/v2/remoteusendit.asmx';
    /**
     * @var mixed|true
     */
    private $useSandbox = false;
    /**
     * @var integer
     */
    private $mobileOperator = -1;
    /**
     * @var bool|true
     */
    private $workingDays = true;
    /**
     * @var bool
     */
    private $isFlash = false;
    private $timezone = 'Europe/Lisbon';

    public function __construct($username = '', $password = '', $sender = null)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        if (!empty($sender))
            $this->setSender($sender);
    }

    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setSender($sender): self
    {
        if (empty($sender)){
            throw new \InvalidArgumentException('The value must be not empty');
        }
        if (is_numeric($sender)){
            if (strlen($sender) > 16){
                throw new \InvalidArgumentException('The value must be less than 16 characters');
            }else{
                $sender = (int) $sender;
            }
        }else{
            if (strlen($sender) > 11){
                throw new \InvalidArgumentException('The value must be less than 11 characters');
            }
        }
        $this->sender = $sender;
        return $this;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Only for you use uSendIt from another country, by default this value will be portuguese domain
     * @param $url
     * @param bool $production
     * @return $this
     */
    public function setUrl($url, bool $production=true): self
    {
        if ($production)
            $this->productionUrl = $url;
        else
            $this->sandboxUrl = $url;
        return $this;
    }

    public function enableSandbox($enable = true): self
    {
        $this->useSandbox = $enable;
        return $this;
    }

    public function setMobileOperator($mobileOperator): self
    {
        $this->mobileOperator = $mobileOperator;
        return $this;
    }

    private function geturl(): string
    {
        return $this->useSandbox ? $this->sandboxUrl : $this->productionUrl;
    }

    public function setWorkingDays($workingDays = true): self
    {
        $this->workingDays = $workingDays;
        return $this;
    }

    public function setIsFlash($isFlash = true): self
    {
        $this->isFlash = $isFlash;
        return $this;
    }

    public function setTimezone($timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function send(SendIt $object)
    {
        if (get_class($object) == Sms::class){
            return $this->sendMessage($object);
        }

        throw new \InvalidArgumentException('Invalid object');
    }

    /**
     * @throws \Exception
     */
    private function sendMessage(Sms $sms): SmsResponse
    {
        $url = $this->geturl();

        $endpoint = $url . '/SendMessage';

        $httpClient = new \GuzzleHttp\Client();

        try {
            $response = $httpClient->request('GET', $endpoint, [
                'query' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sender' => $this->sender,
                    'msisdn' => $sms->getDestinatary(),
                    'mobileOperator' => $this->mobileOperator,
                    'expirationDatetime' => $sms->getExpirationDate(),
                    'messageText' => $sms->getMessageText(),
                    'scheduleDatetime' => $sms->getScheduleDatetime(),
                    'workingDays' => $this->workingDays ? 'true' : 'false',
                    'isFlash' => $this->isFlash ? 'true' : 'false',
                    'beginTime' => $sms->getBeginTime(),
                    'endTime' => $sms->getEndTime(),
                    'timezone' => $this->timezone,
                    'partnerEventId' => $sms->getPartnerEventId(),
                    'partnerMsgId' => $sms->getPartnerMessageId(),
                    'priority' => $sms->getPriority(),
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }


        return new SmsResponse($response);
    }
    /**
     * @throws \Exception
     */
    public function getSchedule($eventId): ScheduleResponse
    {
        $url = $this->geturl();

        $endpoint = $url . '/GetSchedule';

        $httpClient = new \GuzzleHttp\Client();

        try {
            $response = $httpClient->request('GET', $endpoint, [
                'query' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'eventId' => $eventId
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }


        return new ScheduleResponse($response);
    }

}