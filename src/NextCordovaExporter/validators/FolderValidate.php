<?php

namespace bariscodefx\NextCordovaExporter\validators;

/**
 * Class FolderValidate
 * @package bariscodefx\NextCordovaExporter\validators
 
 */
final class FolderValidate
{

    /**
     * Check folder
     * @param string $directory
     */
    public static function checkFolder(string $directory): bool
    {
        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        }

        return true;
    }
}