<?php

declare(strict_types=1);

namespace Scene2d;

use Scene2d\CommandBuilders\CommandProducer;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Models\Color;
use Scene2d\Models\ScenePoint;
use Traversable;

require_once '../vendor/autoload.php';

echo "Starting scene application...\n";

$commandProducer = new CommandProducer();
$scene = new Scene();

$readCommandsFromFile = $argc > 1;

$commands = $readCommandsFromFile
    ? readCommandsFromFile($argv[1])
    : readCommandsFromUserInput();

$drawSceneOnEveryCommand = !$readCommandsFromFile;

foreach ($commands as $commandLine) {
    try {
        $commandProducer->appendLine($commandLine);

        if ($commandProducer->isCommandReady()) {
            $command = $commandProducer->getCommand();
            $command->apply($scene);

            echo $command->friendlyResultMessage();
            if ($drawSceneOnEveryCommand) {
                drawScene($scene);
            }
        }
    } catch (BadFormatException $e) {
        echo "bad format\n";
    }

    /* todo: more exceptions handling here */
}

if (!$drawSceneOnEveryCommand) {
    drawScene($scene);
}

echo 'Commands processing complete.';


function readCommandsFromFile(string $input): array
{
    echo "Reading commands from input file {$input}\n";

    return file(getPathToResource($input));
}

function getPathToResource(string $path): string
{
    $path = ltrim($path, '/');
    return "../resources/{$path}";
}

function readCommandsFromUserInput(): Traversable
{
    while (true) {
        echo 'Enter a command or press Enter to exit';
        echo '> ';

        $line = readline();
        if ($line === false || strlen(trim($line)) === 0) {
            break;
        }

        yield $line;
    }
}

function drawScene(Scene $scene): void
{
    $outputFileName = getPathToResource('Output/scene.png');

    if (file_exists($outputFileName)) {
        unlink($outputFileName);
    }

    $area = $scene->calculateSceneCircumscribingRectangle();
    $origin = new ScenePoint(
        min($area->vertex1->getX(), $area->vertex2->getX()),
        min($area->vertex1->getY(), $area->vertex2->getY())
    );

    $width = (int)abs($area->vertex1->getX() - $area->vertex2->getX()) + 1;
    $height = (int)abs($area->vertex1->getY() - $area->vertex2->getY()) + 1;

    $imageBuilder = new ImageBuilder($width, $height, Color::darkGrey());

    foreach ($scene->listDrawableFigures() as $figure) {
        $figure->draw($origin, $imageBuilder);
    }

    $imageBuilder->create($outputFileName);

    echo "The scene has been saved to {$outputFileName}\n";
}
