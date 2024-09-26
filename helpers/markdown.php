<?php

use Laravel\Unfenced\UnfencedExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

if (!function_exists('markdown_convert')) {
    function markdown_convert($file)
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new UnfencedExtension);
        $environment->addExtension(new TorchlightExtension);

        $converter = new MarkdownConverter($environment);
        return $converter->convert(file_get_contents($file));
    }
}
