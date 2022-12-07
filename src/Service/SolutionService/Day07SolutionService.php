<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day07SolutionService implements DaySolutionServiceInterface
{
    private const DIRECTORY = 'dir';
    private const FILE = 'file';

    public static function getSolution(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result1 = self::calculatePartOne($input);
        $solutionObject->setSolutionForPart1($result1);

        $result2 = self::calculatePartTwo($input);
        $solutionObject->setSolutionForPart2($result2);

        return $solutionObject;
    }

    public static function getSolutionForPartOne(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartOne($input);
        $solutionObject->setSolutionForPart1($result);

        return $solutionObject;
    }

    public static function getSolutionForPartTwo(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartTwo($input);
        $solutionObject->setSolutionForPart2($result);

        return $solutionObject;
    }

    private static function calculatePartOne(string $input): ?int
    {
        $fileSystem = self::parseFileSystemTree($input);

        return array_sum(self::getSizesOfDirectoriesByCriteria($fileSystem['/']));
    }

    private static function calculatePartTwo(string $input): ?string
    {
        $fileSystem = self::parseFileSystemTree($input);

        $diskSize = 70000000;
        $takenSpace = $fileSystem['/']['size'];

        $freeSpace = $diskSize - $takenSpace;
        $neededSpace = 30000000;

        $minimumSpaceToFree = $neededSpace - $freeSpace;

        $directorySizes = self::getSizesOfDirectoriesByCriteria($fileSystem['/'], $minimumSpaceToFree, 'gte');

        return min($directorySizes);
    }

    private static function getSizesOfDirectoriesByCriteria(array $directory, int $size = 100000, string $comparison = 'lte'): array
    {
        $totalSizes = [];

        if (
            ($comparison === 'lte' && $directory['size'] <= $size) ||
            ($comparison === 'gte' && $directory['size'] >= $size)
        ) {
            $totalSizes[] = $directory['size'];
        }

        foreach ($directory['children'] as $child) {
            if ($child['type'] === self::DIRECTORY) {
                $sizesOfChildren = self::getSizesOfDirectoriesByCriteria($child, $size, $comparison);
                $totalSizes = [...$totalSizes, ...$sizesOfChildren];
            }
        }

        return $totalSizes;
    }

    private static function parseFileSystemTree(string $input)
    {
        $commands = array_map(static function (string $commandData) {
            return explode("\n", $commandData);
        }, explode("\n$ ", $input));

        $commands = array_slice($commands, 1);

        $fileSystem = [
            '/' => [
                'type' => self::DIRECTORY,
                'children' => [],
                'size' => 0,
            ],
        ];

        $currentPath = ['/'];
        $currentPathLength = 1;
        foreach ($commands as $command) {
            if (count($command) === 1) {
                $command = explode(" ", $command[0]);

                $newDirectory = $command[1];

                if ($newDirectory === '..') {
                    --$currentPathLength;
                    $currentPath = array_slice($currentPath, 0, $currentPathLength);

                    continue;
                }

                if ($newDirectory === '/') {
                    $currentPathLength = 1;
                    $currentPath = ['/'];

                    continue;
                }

                ++$currentPathLength;
                $currentPath[] = $newDirectory;

                continue;
            }

            $children = array_slice($command, 1);

            foreach ($children as $child) {
                [$meta, $name] = explode(" ", $child);

                $size = 0;
                if ($meta !== self::DIRECTORY) {
                    $size = (int)$meta;
                }

                $parent = &$fileSystem;
                foreach ($currentPath as $directoryName) {
                    $parent = &$parent[$directoryName];
                    $parent['size'] += $size;
                    $parent = &$parent['children'];
                }

                if ($meta === self::DIRECTORY) {
                    $parent[$name] = [
                        'type' => self::DIRECTORY,
                        'children' => [],
                        'size' => $size,
                    ];
                } else {
                    $parent[$name] = [
                        'type' => self::FILE,
                        'size' => $size,
                    ];
                }
            }
        }

        return $fileSystem;
    }
}
