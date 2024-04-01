<?php

namespace NextCordovaExporter;

final class FolderValidate
{
    /**
     * @param string $directory
     * @return bool
     */
    public function checkFolder(string $directory): bool
    {
        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        }

        return true;
    }
}