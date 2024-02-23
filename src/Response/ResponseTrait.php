<?php

namespace Filipeclemente\USendItSdk\Response;

use GuzzleHttp\Psr7\Response;

trait ResponseTrait
{
    protected string $scheduleStatus, $scheduleMessage;

    public function __construct($response = null)
    {
        if (!empty($response))
            $this->setResponse($response);
    }

    public function hasError(): bool
    {
        return  $this->scheduleStatus != 0;
    }

    public function getErrorMessage(): string
    {
        return $this->scheduleMessage;
    }

    public function hasSuccess(): bool
    {
        return !$this->hasError();
    }

    public function setResponse(Response $response): self
    {
        $this->setProperties($this->parseResponse($response));
        return $this;
    }

    private function parseResponse(Response $response): array
    {
        $response = $response->getBody()->getContents();
        $response = simplexml_load_string($response);

        $data = [];

        if (count($response) == 0){
            parse_str($response[0], $data);
        }else{
            $data = (array)$response;
        }
        return $data;
    }

    private function setProperties($data): self
    {
        foreach ($data as $key => $value) {
            $key = $this->lowerFirstChar($key);
            $this->$key = $value;
        }
        return $this;
    }

    function lowerFirstChar($string) {
        if (empty($string)) {
            return $string;
        }
        $firstChar = strtolower($string[0]);
        $restOfString = substr($string, 1);
        return $firstChar . $restOfString;
    }
}