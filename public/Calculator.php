<?php

/**
 * This is for testing PHP-Unit configuration.
 */

class Calculator
{
    /**
     * @assert (0, 0) == 0
     * @assert (0, 1) == 1
     * @assert (1, 0) == 1
     * @assert (1, 1) == 2
     * @assert (1, 2) == 4
     * @assert (50, 1) == 51
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}