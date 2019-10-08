<?php

namespace Werp\Builders\Tables;

use Werp\Builders\BaseBuilder;
use Werp\Builders\Tables\Header;

class TableBuilder
{
    use BaseBuilder;

    protected $name;
    protected $type;
    protected $advancedOption = false;
    protected $width;
    protected $options = [];
    protected $header = [];
    protected $rows = [];

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $value
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->type = 'table';
        $this->width = 's12 m6';
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return InputBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return InputBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isAdvancedOption()
    {
        return $this->advancedOption;
    }

    /**
     * @param mixed $advancedOption
     * @return InputBuilder
     */
    public function setAdvancedOption($advancedOption)
    {
        $this->advancedOption = $advancedOption;
        return $this;
    }

    public function advancedOption()
    {
        $this->setAdvancedOption(true);
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function width()
    {
        return $this->width;
    }

    public function addOption(RadioOptionBuilder $option)
    {
        $this->options = $this->to_collection($this->options);
        $this->options->push($option);
        return $this;
    }

    public function setOptions($options)
    {
        $this->options = $this->to_collection($options);
        return $this;
    }

    public function options()
    {
        return $this->options;
    }

    public function hasOptions()
    {
        return $this->options && $this->options->isNotEmpty();
    }

    public function addHeader(Header $header)
    {
        $this->header = $this->to_collection($this->header);
        $this->header->push($header);
        return $this;
    }

    public function setArrayHeader(array $header)
    {
        foreach ($header as $h) {
            $this->addHeader(new Header($h));
        }

        return $this;
    }

    public function setHeader($header)
    {
        $this->header = $this->to_collection($header);
        return $this;
    }

    public function header()
    {
        return $this->header;
    }

    public function hasHeader()
    {
        return $this->header && $this->header->isNotEmpty();
    }

    public function addRow(Row $row)
    {
        $this->rows = $this->to_collection($this->rows);
        $this->rows->push($row);
        return $this;
    }

    public function setArrayRows(array $rows)
    {
        foreach ($rows as $cells) {
            $row = new Row();
            $row->setArrayCells($cells);
            $this->addRow($row);
        }

        return $this;
    }

    public function setRows($rows)
    {
        $this->rows = $this->to_collection($rows);
        return $this;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function hasRows()
    {
        return $this->rows && $this->rows->isNotEmpty();
    }
}