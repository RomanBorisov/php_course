<?php

declare(strict_types=1);

namespace Scene2d;

use Scene2d\Exceptions\BadNameException;
use Scene2d\Exceptions\NameExistException;
use Scene2d\Figures\CompositeFigure;
use Scene2d\Figures\ICompositeFigure;
use Scene2d\Figures\IFigure;
use Scene2d\Models\ScenePoint;
use Scene2d\Models\SceneRectangle;

class Scene
{
    /**
     * @var IFigure[]
     */
    private array $figures = [];

    /**
     * @var ICompositeFigure[]
     */
    private array $compositeFigures = [];

    public function addFigure(string $name, IFigure $figure): void
    {
        if (array_key_exists($name, $this->figures)) {
            throw new NameExistException('name does already exist');
        }
        $this->figures[$name] = $figure;
    }

    public function calculateSceneCircumscribingRectangle(): SceneRectangle
    {
        $circumscribingRectangles = array_map(
            fn(IFigure $f) => $f->calculateCircumscribingRectangle(),
            $this->listDrawableFigures()
        );

        $allVertices = [];
        foreach ($circumscribingRectangles as $circumscribingRectangle) {
            $allVertices[] = $circumscribingRectangle->vertex1;
            $allVertices[] = $circumscribingRectangle->vertex2;
        }


        if (count($allVertices) === 0) {
            return new SceneRectangle();
        }

        $xCoordinates = array_map(fn(ScenePoint $p): float => $p->getX(), $allVertices);
        $yCoordinates = array_map(fn(ScenePoint $p): float => $p->getY(), $allVertices);

        return new SceneRectangle(
            new ScenePoint(min($xCoordinates), min($yCoordinates)),
            new ScenePoint(max($xCoordinates), max($yCoordinates)),
        );
    }


    /**
     * @param string $name
     * @param string[] $childFigures
     */
    public function createCompositeFigure(string $name, array $childFigures): void
    {
        $figures = [];
        foreach ($childFigures as $childFigure) {
            $figures[$childFigure] = $this->figures[$childFigure];
        }

        $this->compositeFigures[$name] = new CompositeFigure($figures);
    }

    public function calculateCircumscribingRectangle(string $name): SceneRectangle
    {
        return $this->figures[$name]->calculateCircumscribingRectangle();
    }

    public function moveScene(ScenePoint $vector): void
    {
        foreach ($this->figures as $figure) {
            $figure->move($vector);
        }
    }

    public function move(string $name, ScenePoint $vector): void
    {
        if (array_key_exists($name, $this->figures)) {
            $this->figures[$name]->move($vector);
        } elseif (array_key_exists($name, $this->compositeFigures)) {
            $this->compositeFigures[$name]->move($vector);
        } else {
            throw new BadNameException('bad name');
        }
    }

    public function rotateScene(float $angle): void
    {
        foreach ($this->figures as $figure) {
            $figure->rotate($angle);
        }
    }

    public function rotate(string $name, float $angle): void
    {
        if (array_key_exists($name, $this->figures)) {
            $this->figures[$name]->rotate($angle);
        } elseif (array_key_exists($name, $this->compositeFigures)) {
            $this->compositeFigures[$name]->rotate($angle);
        } else {
            throw new BadNameException('bad name');
        }
    }

    /**
     * @return IFigure[]
     */
    public function listDrawableFigures(): array
    {
        $allDrawableFigures = array_values($this->figures);

        foreach ($this->compositeFigures as $compositeFigure) {
            $allDrawableFigures = array_merge($allDrawableFigures, $compositeFigure->getChildFigures());
        }

        return array_unique($allDrawableFigures, SORT_REGULAR);
    }

    public function copyScene(string $copyName): void
    {
        $childFigures = array_keys($this->figures);
        $figureNames = [];
        foreach ($childFigures as $figureName) {
            $clone = $this->figures[$figureName]->clone();
            $this->addFigure($copyName . $figureName, $clone);
            $figureNames[] = $copyName . $figureName;
        }
        $this->createCompositeFigure($copyName, $figureNames);
    }

    public function copy(string $originalName, string $copyName): void
    {
        if (array_key_exists($originalName, $this->figures)) {
            $clone = $this->figures[$originalName]->clone();
            $this->addFigure($copyName, $clone);
        } elseif (array_key_exists($originalName, $this->compositeFigures)) {
            $childFigures = array_keys($this->compositeFigures[$originalName]->getChildFigures());
            $figureNames = [];
            foreach ($childFigures as $figureName) {
                $clone = $this->figures[$figureName]->clone();
                $this->addFigure($copyName . $figureName, $clone);
                $figureNames[] = $copyName . $figureName;
            }
            $this->createCompositeFigure($copyName, $figureNames);
        } else {
            throw new BadNameException('bad name');
        }
    }

    public function deleteScene(): void
    {
        $this->figures = [];
        $this->compositeFigures = [];
    }

    public function delete(string $name): void
    {
        if (array_key_exists($name, $this->figures)) {
            unset($this->figures[$name]);
        } elseif (array_key_exists($name, $this->compositeFigures)) {
            foreach (array_keys($this->compositeFigures[$name]->getChildFigures()) as $figureName) {
                unset($this->figures[$figureName]);
            }
            unset($this->compositeFigures[$name]);
        } else {
            throw new BadNameException('bad name');
        }
    }

    public function reflectScene(string $reflectOrientation): void
    {
        foreach ($this->figures as $figure) {
            $figure->reflect($reflectOrientation);
        }
    }

    public function reflect(string $name, string $reflectOrientation): void
    {
        if (array_key_exists($name, $this->figures)) {
            $this->figures[$name]->reflect($reflectOrientation);
        } elseif (array_key_exists($name, $this->compositeFigures)) {
            $this->compositeFigures[$name]->reflect($reflectOrientation);
        } else {
            throw new BadNameException('bad name');
        }
    }
}
