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
	protected $messagesWidth = 'm12';
	
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->getTitle()));
    }

    public function setMessagesWidth($messagesWidth)
    {
        $this->messagesWidth = $messagesWidth;
        return $this;
    }

    public function messagesWidth()
    {
        return $this->messagesWidth;
    }

}