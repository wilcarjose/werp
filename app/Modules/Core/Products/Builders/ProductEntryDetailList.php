<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class ProductEntryDetailList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              
              'object' => [
                  'id' => 'Number',
                  'product_id' => 'Number',
                  'warehouse_id' => 'Number',
                  'qty' => 'Number',
                  'amount' => 'Number',
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
                  'type' => 'text',
                  'name' => 'qty',
                  'id' => 'qty',
                  'label' => 'Cantidad',
                ],
                [
                  'key' => 'amount',
                  'type' => 'amount',
                  'name' => 'amount',
                  'id' => 'amount',
                  'label' => 'Precio',
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
            ->setRoute('admin.products.product_entry')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text'],
              ['field' => 'warehouse_name', 'name' => 'Almacén' , 'type' => 'text'], 
              ['field' => 'qty', 'name' => 'Cantidad' , 'type' => 'amount'],
              ['field' => 'amount', 'name' => 'Precio' , 'type' => 'amount']
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