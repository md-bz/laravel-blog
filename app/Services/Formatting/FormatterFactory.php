<?php

namespace App\Services\Formatting;

class FormatterFactory
{
    public static function make(string $type): MentionFormatter
    {
        switch ($type) {
            case 'mention':
                return new HyperlinkMentionFormatter();
            default:
                throw new \Exception("Formatter type not supported.");
        }
    }
}
