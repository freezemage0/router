<?php


namespace Freezemage\Router;

use SplHeap;


final class PatternMap extends SplHeap
{
    /**
     * @param Route $value1
     * @param Route $value2
     */
    protected function compare($value1, $value2): int
    {
        return strlen($value1->getPattern()) - strlen($value2->getPattern());
    }
}