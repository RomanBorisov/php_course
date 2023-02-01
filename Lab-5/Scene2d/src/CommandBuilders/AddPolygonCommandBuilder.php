<?php


namespace Scene2d\CommandBuilders;


use Scene2d\Commands\AddFigureCommand;
use Scene2d\Commands\ICommand;
use Scene2d\Exceptions\BadFormatException;
use Scene2d\Exceptions\BadPolygonPointException;
use Scene2d\Figures\IFigure;
use Scene2d\Figures\PolygonFigure;
use Scene2d\Models\ScenePoint;

class AddPolygonCommandBuilder implements ICommandBuilder
{
    private static string $nameRegex = /** @lang PhpRegExp */
        '/^add polygon (?P<name>[\w]*)(#.*)?/';
    private static string $pointRegex = /** @lang PhpRegExp */
        '/add point \((?P<X>-?\d+),\s*(?P<Y>-?\d+)\)(#.*)?/';
    private static string $endRegex = /** @lang PhpRegExp */
        '/^end polygon(#.*)?/';

    /**
     * @var ScenePoint[]
     */
    private static array $polygonPoints = [];

    private ?IFigure $polygon = null;
    private ?string $name = null;
    private bool $isEndOfInput = false;

    public function isCommandReady(): bool
    {
        return $this->isEndOfInput;
    }

    public function appendLine(string $line): void
    {
        if (preg_match(self::$nameRegex, $line, $matches)) {
            $matches = (object)$matches;
            $this->name = $matches->name;
        } else if (preg_match(self::$pointRegex, $line, $matches)) {
            $matches = (object)$matches;
            $newPoint = new ScenePoint((float)$matches->X, (float)$matches->Y);

            if (in_array($newPoint, self::$polygonPoints) === false && $this->checkForIntersection($newPoint) === false) {
                self::$polygonPoints[] = $newPoint;
            } else {
                throw new BadPolygonPointException('Bad polygon point');
            }
        } else if (preg_match(self::$endRegex, $line, $matches)) {
            $this->isEndOfInput = true;
            $this->polygon = new PolygonFigure(self::$polygonPoints);
        } else {
            throw new BadFormatException();
        }
    }

    public function getCommand(): ?ICommand
    {
        return new AddFigureCommand($this->name, $this->polygon);
    }

    private function checkForIntersection(ScenePoint $p2): bool
    {
        $countPoints = count(self::$polygonPoints);
        if ($countPoints < 3) {
            return false;
        }
        $isIntersection = false;
        $p1 = self::$polygonPoints[$countPoints - 1];
        for ($i = 0; $i < $countPoints - 2; $i++) {
            $p3 = self::$polygonPoints[$i];
            $p4 = self::$polygonPoints[$i + 1];
            if (!((max($p1->getY(), $p2->getY()) < min($p3->getY(), $p4->getY())) ||
                    (min($p1->getY(), $p2->getY()) > max($p3->getY(), $p4->getY()))) &&
                !((max($p1->getX(), $p2->getX()) < min($p3->getX(), $p4->getX())) ||
                    (min($p1->getX(), $p2->getX()) > max($p3->getX(), $p4->getX())))) {
                $isIntersection = true;
                break;
            }
        }
        return $isIntersection;
    }

}
