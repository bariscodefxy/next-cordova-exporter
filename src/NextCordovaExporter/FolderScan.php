<?php

namespace NextCordovaExporter;

final class FolderScan extends LoggerClass
{
    /**
     * @param string $directory
     * @return array|null
     */
    public function scanFolder(string $directory): ?array
    {
        if (!is_dir($directory) || !file_exists($directory)) {
            $this->getLogger()->critical("Directory not a folder or not exists.");
            exit(1);
        }

        $files = [];

        foreach(scandir($directory) as $file)
        {
            if($file !== "." && $file !== "..") {
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                if (is_dir($filePath)) {
                    foreach(self::scanFolder($filePath) as $f) $files[] = $f;
                } else if (is_file($filePath)) {
                    $files[] = $filePath;
                }
            }
        }

        return $files;
    }
}