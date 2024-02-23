<?php

namespace Filipeclemente\USendItSdk\Response;

class SmsResponse
{
    use ResponseTrait;

    protected string $scheduleStatus, $scheduleMessage,
        $eventId, $importStatus,
        $partnerEventId, $totalScheduledSMS,
        $totalRecipients, $acceptedRecipients,
        $rejectedRecipients, $msgId, $partnerMsgId,
        $msisdn, $scheduleMessageStatus, $numberSMS,
        $creditsSpent;
}