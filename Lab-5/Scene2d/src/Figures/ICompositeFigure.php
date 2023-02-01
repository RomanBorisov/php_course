<?php


namespace Scene2d\Figures;

/* This interface is not implemented yet */
interface ICompositeFigure extends IFigure
{
    /**
     * @return IFigure[]
     */
    public function getChildFigures(): array;
}
