<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Main\MainList;

class SaleOrderDetailList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              
              'object' => [
                  'id' => 'Number',
                  'product_id' => 'Number',
                  'warehouse_id' => 'Number',
                  'price' => 'Number',
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
                  'endpoint' => '/admin/products/products',
                  'required' => true,
                  'none' => false,
                ],                
                [
                  'key' => 'qty',
                  'type' => 'amount',
                  'name' => 'qty',
                  'id' => 'qty',
                  'label' => 'Cantidad',
                  'required' => true,
                ],

              ],
                
              'advanced_fields' => [
             /*   [
                  'key' => 'warehouses',
                  'type' => 'select',
                  'name' => 'warehouse_id',
                  'id' => 'warehouses',
                  'items' => 'warehouses',
                  'label' => 'Almacén',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/products/warehouses',
                  'required' => false,
                  'none' => false,
                ],
            */
                [
                  'key' => 'taxs',
                  'type' => 'select',
                  'name' => 'tax_id',
                  'id' => 'taxs',
                  'items' => 'taxs',
                  'label' => 'Impuesto',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/sales/taxs',
                  'required' => false,
                  'none' => true,
                ],
                [
                  'key' => 'discounts',
                  'type' => 'select',
                  'name' => 'discount_id',
                  'id' => 'discounts',
                  'items' => 'discounts',
                  'label' => 'Descuento',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'endpoint' => '/admin/sales/discounts',
                  'required' => false,
                  'none' => true,
                ],              
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.sales.orders')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text'],
              //['field' => 'warehouse_name', 'name' => 'Almacén' , 'type' => 'text'], 
              ['field' => 'qty', 'name' => 'Cantidad' , 'type' => 'amount'],
              ['field' => 'price', 'name' => 'Precio' , 'type' => 'amount'],
              ['field' => 'amount', 'name' => 'Sub total' , 'type' => 'amount', 'total' => true],
              ['field' => 'tax_amount', 'name' => 'Impuesto' , 'type' => 'amount', 'total' => true],
              ['field' => 'discount_amount', 'name' => 'Descuento' , 'type' => 'amount', 'total' => true],
              ['field' => 'total_amount', 'name' => 'Total' , 'type' => 'amount', 'total' => true],
            ])
            ->setFilter($filter)
            ->setEmptyList($empty)
            ->setPaginate(false)
            ->setDisable($disable)
            ->setModalConfig($modal)
            ->setReloadOnSave(true)
            ->makeConfig();

        parent::__construct();
    }
}