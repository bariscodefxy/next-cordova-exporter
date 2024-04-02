<?php

namespace NextCordovaExporter;
use NextCordovaExporter\NextScan;
use NextCordovaExporter\FolderValidate;

/**
 * Class Exporter
 * @package NextCordovaExporter
 */
final class Exporter
{
    /**
     * Directory of next.js export directory    
     * @var string
     */
    private string $directory;

    /**
     * Logger
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var \NextCordovaExporter\FolderValidate
     */
    private FolderValidate $folderValidate;

    /**
     * @var \NextCordovaExporter\NextScan
     */
    private NextScan $nextScan;

    /**
     * @var FolderScan
     */
    private FolderScan $folderScan;

    /**
     * @var HtmlParser
     */
    private HtmlParser $htmlParser;

    /**
     * @var int|float
     */
    private int $startTime;

    /**
     * @var AssetCopier
     */
    private AssetCopier $assetCopier;

    /**
     * @var HtmlModifier
     */
    private HtmlModifier $htmlModifier;

    /**
     * @var WebpackModifier
     */
    private WebpackModifier $webpackModifier;

    /**
     * Exporter constructor.
     * @param Logger $logger
     * @param string $directory
     */
    public function __construct(Logger $logger, string $directory)
    {
        $this->logger = $logger;
        $this->directory = $directory;
        $this->folderValidate = new FolderValidate($logger);
        $this->nextScan = new NextScan($logger);
        $this->folderScan = new FolderScan($logger);
        $this->htmlParser = new HtmlParser($logger);
        $this->assetCopier = new AssetCopier($logger);
        $this->htmlModifier = new HtmlModifier($logger);
        $this->webpackModifier = new WebpackModifier($logger);
        $this->startTime = floor(microtime(true) * 1000);

        $this->startScan();
    }

    /**
     * Start scan
     * @return void
     */
    private function startScan()
    {
        $this->logger->info("Starting to exporting...");
        $this->logger->info("Folder is \"{$this->directory}\".");

        if (!$this->folderValidate->checkFolder($this->directory)) {
            $this->logger->critical("Directory is not valid or not exists.");
            exit(1);
        }

        if (!$this->nextScan->checkNextJs($this->directory)) {
            $this->logger->critical("Directory is not a Next.js static exported folder.");
            exit(1);
        }

        $files = $this->folderScan->scanFiles($this->directory);

        $out_dir = $this->directory . "_cordova";
        @mkdir($out_dir);

        foreach ($files as $file) {
            $this->assetCopier->copy($file, $out_dir, PathFunctions::getExtension($file));
            if ( PathFunctions::getExtension($file) === "js" && str_starts_with(PathFunctions::getFileName($file), "webpack") )
            {
                $this->webpackModifier->modify($out_dir . "/js/" . PathFunctions::getBaseName($file));
            } else if ( PathFunctions::getExtension($file) === "html" )
            {
                $this->htmlModifier->modify($file, $out_dir);
            }
        }

        $this->logger->info("Exporting finished in " . abs(floor(microtime(true) * 1000) - $this->startTime) . "ms!");
    }
}