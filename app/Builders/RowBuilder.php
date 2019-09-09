<?php

namespace Werp\Builders;


class RowBuilder
{
    use BaseBuilder;

    protected $id;
    protected $cols;

    /**
     * TabBuilder constructor.
     * @param $id
     * @param $text
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        $this->cols = collect([]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TabBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function addCol(ColBuilder $col)
    {
        $this->cols = $this->to_collection($this->cols);
        $this->cols->push($col);
        return $this;
    }

    public function setCols($cols)
    {
        $this->cols = $this->to_collection($cols);
        return $this;
    }

    public function cols()
    {
        return $this->cols;
    }

    public function hasCols()
    {
        return $this->cols && $this->cols->isNotEmpty();
    }
}