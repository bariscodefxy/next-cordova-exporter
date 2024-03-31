<?php

namespace NextCordovaExporter;

final class HtmlParser extends LoggerClass
{
    /**
     * @param string $htmlFilePath
     * @return array|null
     */
    public function getJSFiles(string $htmlFilePath): ?array
    {
        if (!is_file($htmlFilePath)) {
            $this->getLogger()->error("HTML file not found.");
            exit(1);
        }

        $file = fopen($htmlFilePath, "r");
        $data = fread($file, 1024*10);
        preg_match_all('/\"\/_next([0-9A-Za-z-_\/]+)\.js\"/', $data, $matches);
        fclose($file);

        return $matches[0];
    }
}