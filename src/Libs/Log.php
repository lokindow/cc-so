<?php

namespace Src\Libs;

use Illuminate\Support\Facades\Log as LaravelLog;

class Log
{
    public function __construct(){}

    /**
     * Write log line
     *
     * @param string $strLevel
     * @param string $strMessage
     * @param mixed $varData
     * @return void
     */
    public function writeLine(string $strLevel, string $strMessage, $varData = [])
    {
        $strMessage .= !empty($varData) ? json_encode($varData) : null;
        LaravelLog::{$strLevel}($strMessage);
    }
}
