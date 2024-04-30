<?php

namespace App\Enum;

class CategoryProductEnum
{
    public const FRUITS_LEGUMES = 'fruits_legumes';
    public const BOUCHERIE = 'boucherie';
    public const CHARCUTERIE = 'charcuterie';
    public const CREMERIE = 'cremerie';
    public const MARÉE = 'maree';
    public const EPICERIE = 'epicerie';

    public static function getTypes(): array
    {
        return [
            self::FRUITS_LEGUMES => 'Fruits et Légumes',
            self::BOUCHERIE => 'Boucherie',
            self::CHARCUTERIE => 'Charcuterie',
            self::CREMERIE => 'Crémerie',
            self::MARÉE => 'Marée',
            self::EPICERIE => 'Epicerie',
        ];
    }
}
