<?php

namespace Werp\Transformers;

use Illuminate\Support\Collection;

abstract class Transformer
{
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public function transformData(Collection $items)
    {
        return $items->map([$this, 'transform']);
    }
    
    abstract public function transform($item);
}
