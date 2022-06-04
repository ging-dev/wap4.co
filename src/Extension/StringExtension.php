<?php

use Symfony\Component\String\Slugger\AsciiSlugger;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    private AsciiSlugger $slugger;

    public function __construct()
    {
        $this->slugger = new AsciiSlugger();
    }

    public function getFilters()
    {
        return [
            new TwigFilter('json_decode', [$this, 'json_decode']),
            new TwigFilter('slugify_url', [$this, 'slugify_url']),
        ];
    }

    public function json_decode(string $content)
    {
        return json_decode($content, true);
    }

    public function slugify_url(string $url): string
    {
        return $this->slugger->slug($url);
    }
}
