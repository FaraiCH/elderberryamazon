<?php


namespace Bt\Production\Models;

use function Sodium\increment;

class DataFiller
{
    public static function incrementer($valueOne)
    {
        // get amount of decimals
        $decimal = strlen(strrchr($valueOne, '.')) -1;

        $factor = pow(10, $decimal);

        $incremented = (($factor * $valueOne) + 1) / $factor;

        return $incremented;
    }

    public static function WeightPercentage()
    {
        $starter = 0.000;
        $container = array();
        $val = 0.1;
        foreach (range(0.00, 100, 0.01) as $val) {
            $container[] = $val . "%";
        }

        return $container;
    }
}
