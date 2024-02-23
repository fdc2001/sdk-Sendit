<?php

namespace Filipeclemente\USendItSdk;

use InvalidArgumentException;

class Sms extends SendIt
{
    private $destinatary = '', $text = '';
    private $totalCredits = 0;
    
    private $maxLengthPerCredit = 153;

    /**
     * @var string
     */
    private $expirationDate = null;
    /**
     * @var string
     */
    private $scheduleDateTime = null;
    private $beginTime = null;
    /**
     * @var mixed
     */
    private $endtime = null;
    /**
     * @var mixed
     */
    private $partnerEventId = null;
    /**
     * @var mixed
     */
    private $partnerMessageId = null;
    /**
     * @var mixed
     */
    private $priority = 10;

    public function __construct($destinatary = '', $text = '')
    {
        if (!empty($destinatary))
            $this->setDestinatitary($destinatary);
        if (!empty($text))
            $this->setText($text);
    }

    public function setDestinatitary($destinatary): self
    {
        $destinatary = str_replace('+', '', $destinatary);

        $this->destinatary = $destinatary;
        return $this;
    }

    public function setText($text): self
    {
        $text = trim($text);
        $text = mb_convert_encoding($text, "UTF-16BE", "UTF-8");

        $totalCredits = ceil(strlen($text) / $this->maxLengthPerCredit);

        $this->totalCredits = $totalCredits;
        $this->text = $text;
        
        return $this;
    }

    public function setExpirationDate($expirationDate): self
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    public function setScheduleDateTime($scheduleDateTime): self
    {
        $this->scheduleDateTime = $scheduleDateTime;
        return $this;
    }

    public function getDestinatary()
    {
        return $this->destinatary;
    }

    public function getExpirationDate()
    {
        if ($this->expirationDate)
            return $this->expirationDate;
        return date('Y-m-d H:i:s', strtotime('+1 day'));
    }

    public function getMessageText()
    {
        return $this->text;
    }

    public function getScheduleDatetime()
    {
        if ($this->scheduleDateTime)
            return $this->scheduleDateTime;
        return date('Y-m-d H:i:s');
    }

    public function setBeginTime($beginTime): self
    {
        $this->beginTime = $beginTime;
        return $this;
    }

    public function getBeginTime()
    {
        if ($this->beginTime)
            return $this->beginTime;
        return date('H:i:s');
    }

    public function getEndTime()
    {
        if ($this->endtime)
            return $this->endtime;
        return date('H:i:s');
    }

    public function setEndTime($endTime): self
    {
        $this->endtime = $endTime;
        return $this;
    }

    public function setPartnerEventId($partnerEventId): self
    {
        $this->partnerEventId = $partnerEventId;
        return $this;
    }

    public function getPartnerEventId(): int
    {
        if (empty($this->partnerEventId))
            return rand(1000, 9999);
        return $this->partnerEventId;
    }

    public function setPartnerMessageId($messageId): self
    {
        $this->partnerMessageId = $messageId;
        return $this;
    }

    public function getPartnerMessageId(): int
    {
        if (empty($this->partnerMessageId))
            return rand(1000, 9999);
        return $this->partnerMessageId;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setPriority($priority): self
    {
        if ($priority < 0 || $priority > 100)
            throw new InvalidArgumentException('Priority must be between 0 and 100');
        $this->priority = $priority;
        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }


}