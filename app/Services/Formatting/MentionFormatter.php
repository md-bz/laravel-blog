<?php

namespace App\Services\Formatting;

interface MentionFormatter
{
    public function format(string $content): string;
}
