<?php

namespace App\Services\Formatting;

class HyperlinkMentionFormatter implements MentionFormatter
{
    public function format(string $content): string
    {
        // return preg_replace_callback('/@(\w+)\((https?:\/\/[^\)]+)\)/', function ($matches) {
        return preg_replace_callback('/@(\w+)\(([^)]+)\)/', function ($matches) {
            $username = $matches[1];
            $url = $matches[2];
            return "<a href=\"$url\">@$username</a>";
        }, $content);
    }
}
