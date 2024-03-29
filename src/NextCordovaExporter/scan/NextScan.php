<?php

namespace bariscodefx\NextCordovaExporter\scan;

/**
 * Class NextScan
 * @package bariscodefx\NextCordovaExporter\scan
 */
final class NextScan
{

    /**
     * Check next.js static export
     * @param string $directory
     */
    public static function checkNextJs(string $directory): bool
    {
        if (!file_exists($directory)) {
            return false;
        }

        $files = scandir($directory);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if ($file == "_next") {
                    return true;
                }
            }
        }

        return false;
    }
}