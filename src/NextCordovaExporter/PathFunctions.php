<?php

namespace NextCordovaExporter;

final class PathFunctions
{
    /**
     * @param string $path
     * @return array|string
     */
    public static function getFileName(string $path): array|string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * @param string $path
     * @return array|string
     */
    public static function getBaseName(string $path): array|string
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    /**
     * @param string $path
     * @return array|string
     */
    public static function getExtension(string $path): array|string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}