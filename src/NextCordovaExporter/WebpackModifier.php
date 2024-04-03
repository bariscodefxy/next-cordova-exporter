<?php

namespace NextCordovaExporter;

final class WebpackModifier extends LoggerClass
{
    /**
     * @param string $filepath
     * @return void
     */
    public function modify(string $filepath): void
    {
        if (!is_file($filepath))
        {
            $this->getLogger()->error("No webpack file found with name: $filepath");
        } else if (PathFunctions::getExtension($filepath) !== "js") {
            $this->getLogger()->error("Webpack file is not a JavaScript file.");
        }

        $this->getLogger()->debug("WebpackModifier::modify() \$filepath is '$filepath'");

        $file = fopen($filepath, "r");
        $data = fread($file, filesize($filepath));
        fclose($file);

        // replace '/_next/' to '/'
        $pattern = '/\/_next\//';
        $data = preg_replace($pattern, '/', $data);

        $file = fopen($filepath, "w");
        fwrite($file, $data);
        fclose($file);
    }
}