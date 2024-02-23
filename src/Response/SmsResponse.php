<?php

namespace Filipeclemente\USendItSdk\Response;

class SmsResponse
{
    use ResponseTrait;

    protected $scheduleStatus, $scheduleMessage,
        $eventId, $importStatus,
        $partnerEventId, $totalScheduledSMS,
        $totalRecipients, $acceptedRecipients,
        $rejectedRecipients, $msgId, $partnerMsgId,
        $msisdn, $scheduleMessageStatus, $numberSMS,
        $creditsSpent;
}