<?php

namespace eDemy\MathBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class eDemyMathBundle extends Bundle
{
    public static function getBundleName($type = null)
    {
        if ($type == null) {

            return 'eDemyMathBundle';
        } else {
            if ($type == 'Simple') {

                return 'Math';
            } else {
                if ($type == 'simple') {

                    return 'math';
                }
            }
        }
    }

    public static function eDemyBundle() {

        return true;
    }
}
