<?php

class Utils
{
    public const TEMPLATE_DIR = __DIR__.'/../templates';

    public const CUSTOM_DATA_FILE = __DIR__.'/../custom_data.csv';

    public static function getFile(string $filename)
    {
        return file_exists(Utils::TEMPLATE_DIR.DIRECTORY_SEPARATOR.$filename)
            ? $filename
            : '404';
    }
}
