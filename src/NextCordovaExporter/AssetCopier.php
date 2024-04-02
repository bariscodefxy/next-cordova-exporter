<?php

namespace NextCordovaExporter;

final class AssetCopier extends LoggerClass
{
    /**
     * @param string $from
     * @param string $to
     * @param string $file_type
     * @return void
     */
    public function copy(string $from, string $to, string $file_type): void
    {
        $this->getLogger()->debug("From: $from");
        $this->getLogger()->debug("To: $to");
        @mkdir($to . DIRECTORY_SEPARATOR . ($file_type !== "html" ? $file_type : ""));
        copy($from, $to . DIRECTORY_SEPARATOR . ($file_type !== "html" ? $file_type : "") . DIRECTORY_SEPARATOR . PathFunctions::getBaseName($from));
        $this->getLogger()->info("Copied " . mb_strtoupper($file_type) . " file: " . PathFunctions::getBaseName($from));
    }
}