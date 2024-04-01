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
     * @var HtmlSaver
     */
    private HtmlSaver $htmlSaver;

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
        $this->htmlSaver = new HtmlSaver($logger);
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

        $htmlFiles = $this->folderScan->scanHTMLFiles($this->directory);

        foreach($htmlFiles as $htmlFile) {
            $files = $this->htmlParser->getFiles($htmlFile);
            $out_dir = $this->directory . "_cordova";
            $assets = [];
            @mkdir($out_dir);

            foreach ($files as $file) {
                switch (pathinfo($file, PATHINFO_EXTENSION)) {
                    case "js":
                        $this->assetCopier->copy($this->directory . DIRECTORY_SEPARATOR . $file, $out_dir, "js");
                        break;
                    case "css":
                        $this->assetCopier->copy($this->directory . DIRECTORY_SEPARATOR . $file, $out_dir, "css");
                        break;
                }
                $assets[] = $this->directory . DIRECTORY_SEPARATOR . $file;
            }

            // save html file after end
            $this->htmlSaver->save($htmlFile, $out_dir, $assets);
        }

        $this->logger->info("Exporting finished in " . abs(floor(microtime(true) * 1000) - $this->startTime) . "ms!");
    }
}