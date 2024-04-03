<?php

namespace NextCordovaExporter;

final class AssetCopier extends LoggerClass
{
    /**
     * @var Exporter
     */
    private Exporter $exporter;

    /**
     * @param Exporter $exporter
     * @param Logger $logger
     */
    public function __construct(Exporter $exporter, Logger $logger)
    {
        $this->exporter = $exporter;
        parent::__construct($logger);
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $file_type
     * @return void
     */
    public function copy(string $from, string $to, string $file_type): void
    {
        $fromDir = PathFunctions::getDirName($from);
        $fromDirTmp = $this->exporter->functions->getTmpDir($fromDir);
        $this->getLogger()->debug("From: $from");
        $this->getLogger()->debug("To: $to");
        @mkdir($to . DIRECTORY_SEPARATOR . $fromDirTmp, recursive: true);
        copy($from, $to . DIRECTORY_SEPARATOR . $fromDirTmp . DIRECTORY_SEPARATOR . PathFunctions::getBaseName($from));
        $this->getLogger()->info("Copied " . mb_strtoupper($file_type) . " file: " . PathFunctions::getBaseName($from));
    }
}