<?php

namespace NextCordovaExporter;

final class HtmlParser extends LoggerClass
{
    /**
     * @param string $htmlFilePath
     * @return array|null
     */
    public function getFiles(string $htmlFilePath): ?array
    {
        if (!is_file($htmlFilePath)) {
            $this->getLogger()->error("HTML file not found.");
            exit(1);
        }

        $file = fopen($htmlFilePath, "r");
        $data = fread($file, filesize($htmlFilePath));
        preg_match_all('/\"\/_next([0-9A-Za-z-_\/]+)\.(js|css|png|jpeg|webp|gif)\"/', $data, $matches);
        $matches = $matches[0];
        foreach($matches as $key => $m)
        {
            $matches[$key] = substr(substr($m, 1), 0, -1);
        }
        fclose($file);

        return $matches;
    }
}
