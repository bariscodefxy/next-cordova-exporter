<?php

namespace NextCordovaExporter;

use NextCordovaExporter\Logger;

abstract class LoggerClass
{
    /**
     * @var \NextCordovaExporter\Logger
     */
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger(): ?Logger
    {
        return $this->logger;
    }
}