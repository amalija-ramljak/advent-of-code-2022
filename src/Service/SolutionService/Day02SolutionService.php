<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day02SolutionService implements DaySolutionServiceInterface
{
    private const ROCK = 'rock';
    private const PAPER = 'paper';
    private const SCISSORS = 'scissors';

    private const WIN = 'win';
    private const LOSS = 'loss';
    private const DRAW = 'draw';

    private const LOSES_TO = [
        self::ROCK => self::PAPER,
        self::PAPER => self::SCISSORS,
        self::SCISSORS => self::ROCK,
    ];
    private const BEATS = [
        self::ROCK => self::SCISSORS,
        self::PAPER => self::ROCK,
        self::SCISSORS => self::PAPER,
    ];

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
        $stats = self::getStatistics1($input);

        return self::calculateTotalPoints($stats);
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $stats = self::getStatistics2($input);

        return self::calculateTotalPoints($stats);
    }

    private static function calculateTotalPoints(array $stats): int
    {
        $points = 0;
        foreach ([self::WIN, self::DRAW, self::ROCK, self::PAPER, self::SCISSORS] as $gameSegment) {
            $points += $stats[$gameSegment] * self::getGameSegmentValue($gameSegment);
        }

        return $points;
    }

    private static function getStatistics1(string $input): array
    {
        $games = self::prepGames($input);
        $stats = [
            self::WIN => 0,
            self::LOSS => 0,
            self::DRAW => 0,
            self::ROCK => 0,
            self::PAPER => 0,
            self::SCISSORS => 0,
        ];

        foreach ($games as $gameString) {
            $result = self::getGameResult($gameString);
            ++$stats[$result];

            $myChoice = self::mapLetterToChoice(self::getGameMoves($gameString)[1]);
            ++$stats[$myChoice];
        }

        return $stats;
    }

    private static function getStatistics2(string $input): array
    {
        $games = self::prepGames($input);
        $stats = [
            self::WIN => 0,
            self::LOSS => 0,
            self::DRAW => 0,
            self::ROCK => 0,
            self::PAPER => 0,
            self::SCISSORS => 0,
        ];

        foreach ($games as $gameString) {
            $result = self::mapLetterToResult(self::getGameMoves($gameString)[1]);
            ++$stats[$result];

            $myChoice = self::mapGameToMyChoice($gameString);
            ++$stats[$myChoice];
        }

        return $stats;
    }

    private static function prepGames(string $input): array
    {
        return explode("\n", $input);
    }

    private static function getGameMoves(string $gameString): array
    {
        return explode(" ", $gameString);
    }

    private static function getGameSegmentValue(string $choice): int
    {
        return match ($choice) {
            self::WIN => 6,
            self::DRAW, self::SCISSORS => 3,
            self::ROCK => 1,
            self::PAPER => 2,
            default => 0,
        };
    }

    private static function mapLetterToChoice(string $choice): ?string
    {
        return match ($choice) {
            'A', 'X' => self::ROCK,
            'B', 'Y' => self::PAPER,
            'C', 'Z' => self::SCISSORS,
            default => null,
        };
    }

    private static function mapLetterToResult(string $choice): ?string
    {
        return match ($choice) {
            'X' => self::LOSS,
            'Y' => self::DRAW,
            'Z' => self::WIN,
            default => null,
        };
    }

    private static function mapGameToMyChoice(string $gameString): ?string
    {
        $game = self::getGameMoves($gameString);
        $opponent = self::mapLetterToChoice($game[0]);
        $me = $game[1];

        if ($me === 'X') {
            return self::BEATS[$opponent];
        }

        if ($me === 'Y') {
            return $opponent;
        }

        return self::LOSES_TO[$opponent];
    }

    private static function getGameResult(string $gameString): string
    {
        $game = self::getGameMoves($gameString);

        $opponentChoice = self::mapLetterToChoice($game[0]);
        $myChoice = self::mapLetterToChoice($game[1]);

        if ($opponentChoice === $myChoice) {
            return self::DRAW;
        }

        $rockScissors = $opponentChoice === self::ROCK && $myChoice === self::SCISSORS;
        $scissorsPaper = $opponentChoice === self::SCISSORS && $myChoice === self::PAPER;
        $paperRock = $opponentChoice === self::PAPER && $myChoice === self::ROCK;

        if ($rockScissors || $scissorsPaper || $paperRock) {
            return self::LOSS;
        }

        return self::WIN;
    }
}
