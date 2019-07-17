<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class InventoryDetailList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              'object' => ['id' => 'Number', 'product_id' => 'Number', 'warehouse_id' => 'Number', 'description' => 'String', 'qty' => 'Number' ],
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
                  'key' => 'description',
                  'type' => 'text',
                  'name' => 'description',
                  'id' => 'description',
                  'label' => 'Descripción',
                ],
                [
                  'key' => 'qty',
                  'type' => 'text',
                  'name' => 'qty',
                  'id' => 'qty',
                  'label' => 'Cantidad',
                ],
                [
                  'key' => 'warehouses',
                  'type' => 'select',
                  'name' => 'warehouse_id',
                  'id' => 'warehouses',
                  'items' => 'warehouses',
                  'label' => 'Almacén',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/products/warehouses'
                ]
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.products.inventories')
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