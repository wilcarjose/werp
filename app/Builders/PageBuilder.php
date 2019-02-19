<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 16/02/19
 * Time: 04:03 PM
 */

namespace App\Builders;

class PageBuilder
{
    // move to helpers
    protected function is_collection($elements)
    {
        return $elements instanceof \Illuminate\Database\Eloquent\Collection;
    }

    // move to helpers
    protected function is_not_collection($elements)
    {
        return !$this->is_collection($elements);
    }

    protected function to_collection($elements)
    {
        if ($this->is_collection($elements)) {
            return $elements;
        }

        return collect($elements);
    }
}