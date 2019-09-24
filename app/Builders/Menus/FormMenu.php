<?php

namespace Werp\Builders\Menus;

use Werp\Builders\BaseBuilder;

class FormMenu
{
	protected $itens;

    use BaseBuilder;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function addItem(Item $item)
    {
        $this->items = $this->to_collection($this->items);
        $this->items->push($item);
        return $this;
    }

    public function setItems($items)
    {
        $this->items = $this->to_collection($items);
        return $this;
    }

    public function items()
    {
        return $this->items;
    }

    public function hasItems()
    {
        return $this->items && $this->items->isNotEmpty();
    }

}