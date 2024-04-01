<?php

namespace NextCordovaExporter;

final class HtmlSaver extends LoggerClass
{
    /**
     * @param string $from
     * @param string $to
     * @param array $assets
     * @return void
     */
    public function save(string $from, string $to, array $assets = []): void
    {
        if(pathinfo($from, PATHINFO_EXTENSION) !== "html")
        {
            $this->getLogger()->error("File is not a HTML file.");
            exit(1);
        }

        $file = fopen($from, "r");
        $data = fread($file, filesize($from));
        fclose($file);

        // replace hrefs and sources
        foreach($assets as $asset)
        {
            $baseName = pathinfo($asset, PATHINFO_BASENAME);
            $ext = pathinfo($asset, PATHINFO_EXTENSION);
            switch($ext)
            {
                case "js":
                    $pattern = "/<script(.*)src=\"(.*)" . str_replace('.', '\.', $baseName) . "\"(.*)><\/script>/";
                    $data = preg_replace($pattern, "<script src='" . DIRECTORY_SEPARATOR . $ext . DIRECTORY_SEPARATOR . $baseName . "'></script>", $data);
                    break;
                case "css":
                    $pattern = "/<link(.*)href=\"(.*)" . str_replace('.', '\.', $baseName) . "\"(.*)(\/)?>(<\/link>)?/";
                    $data = preg_replace($pattern, "<link href='" . $ext . DIRECTORY_SEPARATOR . $baseName . "'/>", $data);
                    $pattern = "/_next\/static\/css\/" . str_replace('.', '\.', $baseName) . "/";
                    $data = preg_replace($pattern, $ext . DIRECTORY_SEPARATOR . $baseName, $data);
                    break;
                // TODO: other types...
            }
        }

        $file = fopen($to . DIRECTORY_SEPARATOR . pathinfo($from, PATHINFO_BASENAME), "w");
        fwrite($file, $data);
        fclose($file);

        $this->getLogger()->info("Saved HTML: $from");
    }
}