<?php

namespace App\Entity;

class Monkey
{
    private array $items;
    private string $operationType;
    private int|string $operationValue;
    private int $divisibleBy;
    private int $ifTrue;
    private int $ifFalse;

    private bool $lessenWorry;
    private int $specialMod;

    private int $inspections = 0;

    public function __construct(array $startingItems, string $operation, int $divisibleBy, int $ifTrue, int $ifFalse, bool $lessenWorry = true)
    {
        $this->items = $startingItems;
        $this->divisibleBy = $divisibleBy;
        $this->ifTrue = $ifTrue;
        $this->ifFalse = $ifFalse;
        $this->lessenWorry = $lessenWorry;

        $operationArray = explode(" ", $operation);
        $operation = array_slice($operationArray, -2);

        $this->operationType = $operation[0];
        if ($operation[1] === 'old') {
            $this->operationValue = $operation[1];
        } else {
            $this->operationValue = (int)$operation[1];
        }
    }

    public function setSpecialMod(int $specialMod): void
    {
        $this->specialMod = $specialMod;
    }
    
    public function catchItem(int $item): void
    {
        $this->items[] = $item;
    }

    public function takeTurn(): array
    {
        $throwActions = [];

        foreach ($this->items as $itemWorry) {
            $throwActions[] = $this->handleItem($itemWorry);
        }

        $this->items = [];

        return $throwActions;
    }

    private function handleItem(int $worry): array
    {
        $this->inspections++;

        $newWorry = $this->applyOperation($worry);

        if ($this->lessenWorry) {
            $newWorry /= 3;
            $newWorry = floor($newWorry);
        } else {
            $newWorry %= $this->specialMod;
        }

        $monkey = $this->ifFalse;
        if ($newWorry % $this->divisibleBy === 0) {
            $monkey = $this->ifTrue;
        }

        return ['monkey' => $monkey, 'item' => $newWorry];
    }

    private function applyOperation(int $worry): int|float
    {
        $operationValue = $this->operationValue === 'old' ? $worry : $this->operationValue;

        return match ($this->operationType) {
            '*' => $operationValue * $worry,
            '+' => $operationValue + $worry,
        };
    }

    public function getInspections(): int
    {
        return $this->inspections;
    }
}
