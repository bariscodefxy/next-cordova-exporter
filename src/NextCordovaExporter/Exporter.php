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
     * @var string
     */
    private string $cordovaOutputDir;

    /**
     * @var Functions
     */
    public Functions $functions;

    /**
     * Exporter constructor.
     * @param Logger $logger
     * @param string $directory
     */
    public function __construct(Logger $logger, string $directory, ?string $outdir = null)
    {
        $this->logger = $logger;
        $this->functions = new Functions($this);
        $this->directory = realpath($directory);
        $this->folderValidate = new FolderValidate();
        $this->nextScan = new NextScan($logger);
        $this->folderScan = new FolderScan($logger);
        $this->htmlParser = new HtmlParser($logger);
        $this->assetCopier = new AssetCopier($this, $logger);
        $this->htmlModifier = new HtmlModifier($logger);
        $this->webpackModifier = new WebpackModifier($logger);
        $this->cordovaOutputDir = $outdir ?? $this->directory . "_cordova";
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

        @mkdir($this->cordovaOutputDir);

        foreach ($files as $file) {
            $this->assetCopier->copy($file, $this->cordovaOutputDir, PathFunctions::getExtension($file));
            if ( PathFunctions::getExtension($file) === "js" && str_starts_with(PathFunctions::getFileName($file), "webpack") )
            {
                $this->webpackModifier->modify($this->cordovaOutputDir . DIRECTORY_SEPARATOR . $this->functions->getTmpDir($file));
            } else if ( PathFunctions::getExtension($file) === "html" )
            {
                $this->htmlModifier->modify($file, $this->cordovaOutputDir);
            }
        }

        $this->logger->info("Exporting finished in " . abs(floor(microtime(true) * 1000) - $this->startTime) . "ms!");
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function __get(string $var): mixed
    {
        return $this->{$var};
    }

    /**
     * @param string $var
     * @param mixed $val
     * @return void
     */
    public function __set(string $var, mixed $val): void
    {
        $this->{$var} = $val;
    }
}