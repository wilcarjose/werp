<?php

namespace Werp\Modules\Core\Base\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Base\Responses\DependencyResponse;
use Werp\Modules\Core\Base\Exceptions\CanNotDeleteException;

class BaseService
{
	protected $entity;

    protected $entityDetail;

    public function begin()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }

    public function rollback()
    {
        DB::rollBack();
    }

    public function getById($id, $exception = true)
    {
        return $exception ? $this->entity->findOrFail($id) : $this->entity->find($id);
    }

    public function getActiveById($id)
    {
        return $this->entity->active()->where('id', $id)->first();
    }

    protected function filters($entity)
    {
        return $entity;
    } 

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->filters($this->entity)
            ->where(function ($query) use ($search) {
                //if ($search) {
                //    $query->where('name', 'like', "$search%");
                //}
            })
            ->orderBy("$sort", "$order");

        $total = $entities->count();

        if ($total <= 0) {
            return [[], []];
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
        $data = $this->makeCreateData($data);
        
        $entity = $this->entity->create($data);

        $entity = $this->postCreate($entity);

        return $entity;
    }

    public function update($id, $data)
    {
        $entity = $this->entity->find($id);

        if (!$entity) {
            return false;
        }

        $data = $this->makeUpdateData($id, $data);

        $entity = $this->entity->where('id', $id)->update($data);

        $entity = $this->postUpdate($entity);

        return $entity;
    }

    public function delete($id)
    {
        $this->begin();

        $ids = is_array($id) ? $id : [$id];

        $response = $this->getDependencies($ids);

        if ($response->success()) {
            $this->rollback();
            throw new CanNotDeleteException($response);
        }

        $this->entity->destroy($ids);

        $this->commit();
    }

    public function getDependencies($ids)
    {
        $dependencies = [];

        foreach ($ids as $id) {
            $entity = $this->getById($id);

            foreach ($entity->getCheckOnDrop() as $dep) {
                if ($dep['class']::where($dep['field'], $id)->exists()) {
                    $dependencies[] = $dep; 
                }
            }
        }

        return new DependencyResponse($dependencies);
    }

    public function changeStatus($id)
    {
    	if (is_array($id)) {

    		$entities = $this->entity->whereIn('id', $id)->get();

	        if ($entities->count() > 0) {

	            foreach ($entities as $entity) {

	            	$result = $this->setStatus($entity);

                    if ($result) {
                        $this->postChangeStatus($entity);
                    }
	            }

	            return true;
	        }

	        return false;
    	}

        $entity = $this->entity->find($id);

    	$result = $this->setStatus($entity);

        if ($result) {
            $this->postChangeStatus($entity);
        }

        return $result;
    }

    protected function setStatus($entity)
    {
    	if ($entity && isset($entity->active)) {
            $entity->active = ($entity->active == BaseModel::STATUS_ACTIVE) ? BaseModel::STATUS_INACTIVE : BaseModel::STATUS_ACTIVE;
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

        $data = $this->makeData($data, $entityDetail->getMaster());

        $entityDetail->update($data);

        return $entityDetail;
    }

    public function deleteDetail($id, $detailId)
    {
        $ids = is_array($detailId) ? $detailId : [$detailId];

        foreach ($ids as $id) {
            $entity = $this->entityDetail->findOrFail($id);
            $entity->delete();
        }
        
        return true;
    }

    protected function makeData($data, $entity = null)
    {
        return $data;
    }

    protected function makeUpdateData($id, $data)
    {
        return $data;
    }

    protected function makeCreateData($data)
    {
        return $data;
    }

    public function postCreate($entity)
    {
        return $entity;
    }

    public function postUpdate($entity)
    {
        return $entity;
    }

    public function postChangeStatus($entity)
    {
        return $entity;
    }
}
