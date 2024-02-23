<?php

namespace Filipeclemente\USendItSdk\Response;

class ScheduleResponse
{
    use ResponseTrait;

    protected string $scheduleStatus, $scheduleMessage,
        $eventId, $importStatus, $totalScheduledSMS, $totalRecipients,
        $acceptedRecipients, $rejectedRecipients, $creditsSpent;

    protected array $SmsScheduledList = [];

    public function __construct($response = null)
    {
        if (!empty($response))
            $this->setResponse($response);
    }
}