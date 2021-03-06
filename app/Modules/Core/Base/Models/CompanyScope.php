<?php

namespace Werp\Modules\Core\Base\Models;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Werp\Modules\Core\Maintenance\Models\Company;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getCompanyKey(), session('company') ? session('company')->id : Company::first()->id); 
    }
}