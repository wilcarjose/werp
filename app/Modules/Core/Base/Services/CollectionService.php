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

	public function fields($fields)
	{
		$this->fields = $fields ? explode(',', $fields) : [];
		return $this;
	}

	public function toArray()
    {
        $query = //empty($this->fields) ?
        	//$this->model :
        	$this->model->setHidden($this->fields);

    	$query = $this->model;

        $query = $query->where(function ($q) {
                if ($this->search) {
                	foreach ($this->searchFields as $field) {
                		$this->matchAll ?
                    		$q->where($field, 'like', '%'.$this->search.'%') :
                    		$q->orWhere($field, 'like', '%'.$this->search.'%');
                    }
                }
            });

        if ($this->sort) {
            $query->orderBy($this->sort, $this->order);
        }

        $total = $query->count();

        if ($total <= 0) {
            return [[], []];
        }

        if ($this->fields) {
	        //$query = $query->makeHidden($this->fields);
	    }

        $collection = $this->paginate == 'off' ? $query : $query->paginate(10);

        $paginator = $this->getPaginator($collection, $total);

        $data = $this->paginate == 'off' ? $collection->get() : $collection->all();

        return [$data, $paginator];
    }

    protected function getPaginator($collection, $total)
    {
    	return $this->paginate == 'off' ? [
                'total_count'  => $total,
                'total_pages'  => 1,
                'current_page' => 1,
                'limit'        => $total
            ] : [
                'total_count'  => $collection->total(),
                'total_pages'  => $collection->lastPage(),
                'current_page' => $collection->currentPage(),
                'limit'        => $collection->perPage()
            ];
    }
}
