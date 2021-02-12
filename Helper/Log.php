<?php

namespace Hibrido\ColorPalette\Helper;

use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;

class Log
{
    public static function createLog($data, $logName = false)
    {
        $logName = !$logName ? 'debug_diniz' : $logName;
        $writer = new Stream(BP . '/var/log/' . $logName . '.log');
        $logger = new Logger();
        $logger->addWriter($writer);
        $logger->info(json_encode($data, JSON_PRETTY_PRINT));
    }
}