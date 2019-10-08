<?php

namespace Werp\Builders\Tables;

use Werp\Builders\BaseBuilder;

class Row
{
    use BaseBuilder;

    protected $cells = [];

    public function addCell(Cell $cell)
    {
        $this->cells = $this->to_collection($this->cells);
        $this->cells->push($cell);
        return $this;
    }

    public function setArrayCells(array $cells)
    {
        foreach ($cells as $cell) {
            $this->addCell(new Cell($cell));
        }

        return $this;
    }

    public function setCells($cells)
    {
        $this->cells = $this->to_collection($cells);
        return $this;
    }

    public function cells()
    {
        return $this->cells;
    }

    public function hasCells()
    {
        return $this->cells && $this->cells->isNotEmpty();
    }
}