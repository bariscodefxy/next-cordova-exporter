<?php

namespace bariscodefx\NextCordovaExporter\exporter;
use bariscodefx\NextCordovaExporter\scan\NextScan;
use bariscodefx\NextCordovaExporter\validators\FolderValidate;

/**
 * Class Exporter
 * @package bariscodefx\NextCordovaExporter\exporter
 */
final class Exporter
{
    /**
     * Directory of next.js export directory    
     * @var string
     */
    private string $directory;

    /**
     * Exporter constructor.
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        $this->directory = $directory;

        $this->startScan();
    }

    /**
     * Start scan
     * @return void
     */
    private function startScan()
    {
        if (!FolderValidate::checkFolder($this->directory)) {
            echo "Directory is not valid or not exists.\n";
            exit(1);
        }

        if (!NextScan::checkNextJs($this->directory)) {
            echo "Directory is not a Next.js static exported project.\n";
            exit(1);
        }
    }
}