<?php

namespace NextCordovaExporter;

final class FolderScan extends LoggerClass
{
    /**
     * @param string $directory
     * @return array|null
     */
    public function scanHTMLFiles(string $directory): ?array
    {
        if (!is_dir($directory) || !file_exists($directory)) {
            $this->getLogger()->critical("Directory not a folder or not exists.");
            exit(1);
        }

        $files = [];

        foreach(scandir($directory) as $file)
        {
            if($file !== "." && $file !== "..")
            {
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                if(is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === "html")
                {
                    $files[] = $filePath;
                }
            }
        }

        return $files;
    }
}