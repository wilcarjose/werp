<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Purchases\Models\Category;

class CategoryService extends BaseService
{
    protected $entity;

    protected $type = Category::PRODUCT_TYPE;

    public function __construct(Category $entity)
    {
        $this->entity = $entity;
    }

    protected function filters($entity)
    {
        return $entity->where('type', $this->type);
    }

    protected function makeUpdateData($id, $data)
    {
        $data['type'] = $this->type;
        return $data;
    }

    protected function makeCreateData($data)
    {
        $data['type'] = $this->type;

        return $data;
    }
}


