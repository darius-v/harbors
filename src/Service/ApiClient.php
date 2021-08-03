<?php

namespace App\Service;

class ApiClient
{
    public function fetch(string $url): string
    {
        return file_get_contents($url);
    }
}