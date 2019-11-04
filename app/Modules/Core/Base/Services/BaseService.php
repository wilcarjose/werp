<?php

namespace Werp\Modules\Core\Base\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Base\Responses\DependencyResponse;
use Werp\Modules\Core\Base\Exceptions\DeleteRestrictionException;

class BaseService
{
	protected $entity;

    protected $entityLine;

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

    public function getModel()
    {
        return $this->entity;
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
        try {

            $this->begin();

            $ids = is_array($id) ? $id : [$id];

            $this->entity->destroy($ids);

            $this->commit();

        } catch (DeleteRestrictionException $e) {

            $this->rollback();
            throw new DeleteRestrictionException;

        } catch (\Exception $e) {

            $this->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function copy($object)
    {
        $data = array_only($object->toArray(), $object->getCopyable());

        return $this->create($data);
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

    public function createLine($id, $data)
    {
        $entity = $this->getById($id);

        $data = $this->makeData($data, $entity);

        return $entity->lines()->create($data);
    }

    public function updateLine($data, $lineId)
    {
        $entityLine = $this->entityLine->findOrFail($lineId);

        $data = $this->makeData($data, $entityLine->getMaster());

        $entityLine->update($data);

        return $entityLine;
    }

    public function deleteLine($id, $lineId)
    {
        $ids = is_array($lineId) ? $lineId : [$lineId];

        foreach ($ids as $id) {
            $entity = $this->entityLine->findOrFail($id);
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
