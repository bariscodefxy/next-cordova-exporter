<?php

namespace NextCordovaExporter;

abstract class LoggerClass
{
    /**
     * @var Logger
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