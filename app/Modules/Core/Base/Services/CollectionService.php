<?php

namespace Werp\Modules\Core\Base\Services;

use Illuminate\Database\Eloquent\Model;

class CollectionService
{
	protected $model;
	protected $sort;
	protected $order;
	protected $search;
	protected $paginate;
	protected $fields = null;
	protected $searchFields;
	protected $matchAll;

	public function model(Model $model)
	{
		$this->model = $model;
		return $this;
	}

	public function sort($sort, $order = 'asc')
	{
		$this->sort = $sort;
		$this->order = $order;
		return $this;
	}

	public function search($search, $fields, $matchAll = true)
	{
		$this->search = $search;
		$this->searchFields = explode(',', $fields);
		$this->matchAll = $matchAll;
		return $this;
	}

	public function paginate($paginate)
	{
		$this->paginate = $paginate;
		return $this;
	}

	public function get()
    {
        $query = $this->model->where(function ($q) {
            if ($this->search) {
            	foreach ($this->searchFields as $field) {
            		$this->matchAll ?
                		$q->where($field, 'like', '%'.$this->search.'%') :
                		$q->orWhere($field, 'like', '%'.$this->search.'%');
                }
            }
        });

        if ($this->sort) {
            $query = $query->orderBy($this->sort, $this->order);
        }

        return $this->paginate == 'on' ? $query->paginate(5) : $query->get();
    }
}
