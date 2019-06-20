<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class ConfigTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'key'                => $item['key'],
            'value'              => $item['value'],
        ];
    }
}
