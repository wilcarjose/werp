<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace App\Builders;


class ListBuilder extends ModuleBuilder
{
    public function view()
    {
        return view('admin.base.list', [
            'page' => $this
        ]);
    }
}