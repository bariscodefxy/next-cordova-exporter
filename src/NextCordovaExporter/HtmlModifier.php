<?php

namespace NextCordovaExporter;

final class HtmlModifier extends LoggerClass
{
    /**
     * @param string $from
     * @param string $to
     * @return void
     */
    public function modify(string $from, string $to): void
    {
        if(PathFunctions::getExtension($from) !== "html")
        {
            $this->getLogger()->error("File is not a HTML file.");
            exit(1);
        }

        $file = fopen($from, "r");
        $data = fread($file, filesize($from));
        fclose($file);

        $pattern = "/\/_next\/static\/chunks\/(app\/)?/";
        $data = preg_replace($pattern, "js/", $data);

        $pattern = "/\/_next\/static\/css\/(app\/)?/";
        $data = preg_replace($pattern, "css/", $data);

        $file = fopen($to . DIRECTORY_SEPARATOR . PathFunctions::getBaseName($from), "w");
        fwrite($file, $data);
        fclose($file);

        $this->getLogger()->info("Saved HTML: $from");
    }
}