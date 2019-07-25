<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class MovementDetailList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              'object' => [
                'id' => 'Number',
                'product_id' => 'Number',
                'warehouse_from_id' => 'Number',
                'warehouse_to_id' => 'Number',
                'qty' => 'Number'
              ],
              'fields' => [
                [
                  'key' => 'products',
                  'type' => 'select',
                  'name' => 'product_id',
                  'id' => 'products',
                  'items' => 'products',
                  'label' => 'Producto',
                  'id_key' => 'id',
                  'value_key' => 'code_name',
                  'endpoint' => '/admin/products/products'
                ],
                [
                  'key' => 'qty',
                  'type' => 'amount',
                  'name' => 'qty',
                  'id' => 'qty',
                  'label' => 'Cantidad',
                ],                
              ],
              'advanced_fields' => [
                [
                  'key' => 'warehouses_from',
                  'type' => 'select',
                  'name' => 'warehouse_from_id',
                  'id' => 'warehouses_from',
                  'items' => 'warehouses_from',
                  'label' => 'Almacén desde',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/products/warehouses'
                ],
                [
                  'key' => 'warehouses_to',
                  'type' => 'select',
                  'name' => 'warehouse_to_id',
                  'id' => 'warehouses_to',
                  'items' => 'warehouses_to',
                  'label' => 'Almacén hasta',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/products/warehouses'
                ]
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.products.movements')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text'], 
              ['field' => 'qty', 'name' => 'Cantidad' , 'type' => 'text']
            ])
            ->setFilter($filter)
            ->setEmptyList($empty)
            ->setPaginate(false)
            ->setDisable($disable)
            ->setModalConfig($modal)
            ->makeConfig();

        parent::__construct();
    }
}