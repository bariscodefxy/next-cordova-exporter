<?php

namespace NextCordovaExporter;

final class Functions
{
    /**
     * @var Exporter
     */
    private Exporter $exporter;

    /**
     * @param Exporter $exporter
     */
    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;
    }

    /**
     * @return Exporter
     */
    public function getExporter(): Exporter
    {
        return $this->exporter;
    }

    /**
     * @param string $fromDir
     * @return string|null
     */
    public function getTmpDir(string $fromDir): ?string
    {
        $fromDirTmp = explode($this->exporter->directory, $fromDir);
        $fromDirTmp = end($fromDirTmp);
        $fromDirTmp = explode('_next/', $fromDirTmp);
        return end($fromDirTmp);
    }
}