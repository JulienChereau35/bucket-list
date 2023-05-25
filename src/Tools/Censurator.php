<?php

namespace App\Tools;

class Censurator
{
    private array $censor = ['noob', 'bot', 'mechant', 'mad'];
    public function purify(string $text): String
    {

        $censoredText = str_ireplace($this->censor, '****', $text);
        return $censoredText;
    }




}