<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MoyFilter extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('moy', [$this, 'moy']),
        ];
    }

    public function moy(array $array): string
    {

        return array_sum($array)/count($array);
    }
}