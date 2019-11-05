<?php

namespace Werp\Modules\Core\Base\Services;

use Illuminate\Database\Eloquent\Model;

class CollectionService
{
	protected $model;
	protected $sort;
	protected $direction;
	protected $query = [];
	protected $paginate = 15;
	protected $fields = null;
	protected $matchAll;

	public function model(Model $model)
	{
		$this->model = $model;
		return $this;
	}

	public function sort($sort, $direction = 'asc')
	{
		$this->sort = substr($sort, 0, 1) == '-' ? substr($sort, 1) : $sort;
		$this->direction = substr($sort, 0, 1) == '-' ? 'desc' : 'asc';
		return $this;
	}

	public function query($query, $matchAll = true)
	{
        $query = explode(',', $query);

        foreach ($query as $q) {
            $qr = explode(':', $q);

            if (count($qr) < 2 || count($qr) > 3) {
                continue;
            }

            if (count($qr) == 2) {
                $qr[2] = $qr[1];
                $qr[1] = 'eq';
            }

            $fields = explode('|', $qr[0]);

            foreach ($fields as $f) {
                $this->query[] = [
                    'field' => $f,
                    'condition' => $qr[1],
                    'value' => $qr[2] === 'null' ? null : $qr[2],
                ];
            }
        }

		$this->matchAll = $matchAll;
		return $this;
	}

	public function paginate($paginate)
	{
		$this->paginate = $paginate == 'on' ? 15 : $paginate;
		return $this;
	}

	public function get()
    {
        $query = $this->model->where(function ($q) {
            if (!empty($this->query)) {
            	foreach ($this->query as $condition) {

                    if ($condition['condition'] == 'in') {
                        $values = explode('|', $condition['value']);
                        $q->whereIn($condition['field'], $values);
                        continue;
                    }

            		$this->matchAll ?
                		$q->where($condition['field'] , $this->getCondition($condition['condition']), $this->getValue($condition['value'], $condition['condition'])) :
                		$q->orWhere($condition['field'] , $this->getCondition($condition['condition']), $this->getValue($condition['value'], $condition['condition']));
                }
            }
        });

        if ($this->sort) {
            $query = $query->orderBy($this->sort, $this->direction);
        }

        return $this->paginate == 'off' ? $query->get() : $query->paginate((int)$this->paginate);
    }

    protected function getCondition($condition)
    {
        if ($condition == 'has' || $condition == 'ew' || $condition == 'sw') {
            return 'LIKE';
        }

        return '=';
    }

    protected function getValue($value, $condition = null)
    {
        if (is_null($condition)) {
            return $value;
        }

        if ($condition == 'has') {
            return '%'.$value.'%';
        }

        if ($condition == 'ew') {
            return '%'.$value;
        }

        if ($condition == 'sw') {
            return $value.'%';
        }

        return $value;
    }
}
