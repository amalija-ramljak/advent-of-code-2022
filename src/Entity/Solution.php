<?php

namespace App\Entity;

class Solution
{
    private int $day;
    private ?int $part1 = null;
    private ?int $part2 = null;

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

    public function getPart1(): ?int
    {
        return $this->part1;
    }

    public function setSolutionForPart1(int $part1Solution): void
    {
        $this->part1 = $part1Solution;
    }

    public function getPart2(): ?int
    {
        return $this->part2;
    }

    public function setSolutionForPart2(int $part2Solution): void
    {
        $this->part2 = $part2Solution;
    }
}
