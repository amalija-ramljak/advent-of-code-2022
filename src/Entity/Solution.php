<?php

namespace App\Entity;

class Solution
{
    private int $day;
    private int|string|null $part1 = null;
    private int|string|null $part2 = null;

    public function __construct(int $day)
    {
        $this->day = $day;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setDay(int $day): void
    {
        $this->day = $day;
    }

    public function getPart1(): int|string|null
    {
        return $this->part1;
    }

    public function setSolutionForPart1(int|string|null $part1Solution): void
    {
        $this->part1 = $part1Solution;
    }

    public function getPart2(): int|string|null
    {
        return $this->part2;
    }

    public function setSolutionForPart2(int|string|null $part2Solution): void
    {
        $this->part2 = $part2Solution;
    }

    public function toArray()
    {
        return [
            'day' => $this->day,
            'part1' => $this->part1,
            'part2' => $this->part2,
        ];
    }
}
