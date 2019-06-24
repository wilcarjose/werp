<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Werp\Modules\Core\Purchases\Models\Category;
use Werp\Modules\Core\Purchases\Builders\CategoryForm;
use Werp\Modules\Core\Purchases\Builders\CategoryList;
use Werp\Modules\Core\Purchases\Transformers\CategoryTransformer;
use Werp\Modules\Core\Products\Controllers\CategoryController as CategoryControllerBase;

class CategoryController extends CategoryControllerBase
{
    protected $category;
    protected $categoryTransformer;
    protected $categoryForm;
    protected $categoryList;
    protected $type = 'supplier';

    public function __construct(Category $category, CategoryTransformer $categoryTransformer, CategoryForm $categoryForm, CategoryList $categoryList)
    {
        $this->category            = $category;
        $this->categoryTransformer = $categoryTransformer;
        $this->categoryForm     = $categoryForm;
        $this->categoryList     = $categoryList;
    }
}
