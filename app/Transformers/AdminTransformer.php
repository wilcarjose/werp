<?php

namespace Werp\Transformers;

class AdminTransformer extends Transformer
{
    public function transform($item)
    {
        $inrole=$this->roleName($item->roles->toArray());
        return [
            'id'          => $item->id,
            'name'        => $item->name,
            'email'       => $item->email,
            'active' => $this->active,
            'designation' => $item->designation,
            'inrole'      => count($inrole) >0 ?$inrole[0]:'',
        ];
    }

    public function roleName($roles)
    {
        $inRoles = [];
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $inRoles[] = $role['name'];
            }
        }
        return $inRoles;
    }

    public function single($item)
    {
        return [
            'id'     => $item['id'],
            'name'   => $item['name'],
            'email'  => $item['email'],
            'active' => $item['active'],
            'inrole' => $this->roleName($item['roles'])
        ];
    }
}
