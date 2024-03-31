<?php

namespace NextCordovaExporter;

final class NextScan extends LoggerClass
{

    /**
     * @param string $directory
     * @return bool
     */
    public function checkNextJs(string $directory): bool
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