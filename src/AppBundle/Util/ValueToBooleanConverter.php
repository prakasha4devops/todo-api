<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Util; 

/**
 * Util class to convert string into boolean
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
final class ValueToBooleanConverter 
{
    /**
     * Converts a string into a boolean
     * 
     * @param mixed $value The value to convert
     * @return boolean
     * @throws \InvalidArgumentException The value is not a valid boolean value
     */
    static public function convert($value) 
    {
        if (is_string($value)) {
            $value = strtolower($value); 
        } 

        $trueValues = array(true, 'true', 'yes', 'on', 1, '1'); 
        if (in_array($value, $trueValues, true) === true) {
            return true; 
        } 

        $falseValues = array(false, 'false', 'no', 'off', 0, '0'); 
        if (in_array($value, $falseValues, true) === false) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid boolean value "%s"', 
                $value
            )); 
        }

        return false; 
    } 
}
