<?php

namespace Werp\Services;

use Werp\Models\BaseModel;

class BaseService
{
	protected $entity;

    protected $entityDetail;

    public function getById($id, $exception = true)
    {
        return $exception ? $this->entity->findOrFail($id) : $this->entity->find($id);
    }

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->entity->where(function ($query) use ($search) {
            //if ($search) {
            //    $query->where('name', 'like', "$search%");
            //}
        })
        ->orderBy("$sort", "$order");

        $total = $entities->count();

        if ($total <= 0) {
            return [];
        }

        $entities = $paginate == 'off' ? $entities : $entities->paginate(10);

        $paginator = $paginate == 'off' ? [
                'total_count'  => $total,
                'total_pages'  => 1,
                'current_page' => 1,
                'limit'        => $total
            ] : [
                'total_count'  => $entities->total(),
                'total_pages'  => $entities->lastPage(),
                'current_page' => $entities->currentPage(),
                'limit'        => $entities->perPage()
            ];

        $data = $paginate == 'off' ? $entities->get()->toArray() : $entities->all();

        return [$data, $paginator];
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update($id, $data)
    {
        $entity = $this->entity->find($id);

        if (!$entity) {
            return false;
        }

        $data = $this->makeUpdateData($id, $data);

        return $this->entity->where('id', $id)->update($data);
    }

    public function delete($id)
    {
    	$ids = is_array($id) ? $id : [$id];
    	return	$this->entity->destroy($id);
    }

    public function changeStatus($id)
    {
    	if (is_array($id)) {

    		$entities = $this->entity->whereIn('id', $id)->get();

	        if ($entities->count() > 0) {
	            foreach ($entities as $entity) {
	            	$this->setStatus($entity);
	            }

	            return true;
	        }

	        return false;
    	}

    	return $this->setStatus($this->entity->find($id));
    }

    protected function setStatus($entity)
    {
    	if ($entity && isset($entity->status)) {
            $entity->status = ($entity->status == BaseModel::STATE_ACTIVE) ? BaseModel::STATE_INACTIVE : BaseModel::STATE_ACTIVE;
            return $entity->save();
        }

        return false;
    }

    public function createDetail($id, $data)
    {
        $entity = $this->getById($id);

        $data = $this->makeData($data, $entity);
        
        return $entity->detail()->create($data);
    }

    public function updateDetail($data, $detailId)
    {
        $entityDetail = $this->entityDetail->findOrFail($detailId);

        return $entityDetail->update($data);
    }

    public function deleteDetail($id, $detailId)
    {
        $entity = $this->entityDetail->findOrFail($detailId);
        $entity->delete();
    }

    protected function makeData($data, $entity = null)
    {
        return $data;
    }

    protected function makeUpdateData($id, $data)
    {
        return $data;
    }
}
