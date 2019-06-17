<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Builders\Main;

use Werp\Builders\ListBuilder;
use Werp\Builders\BreadcrumbBuilder;

class MainList extends ListBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->getTitle()));
    }

}