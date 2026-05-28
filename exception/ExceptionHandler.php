<?php
namespace Exception;

class Exception
{
    private $message = null;
    public function __construct($message = null)
    {
        $this->message = $message;
    }
}