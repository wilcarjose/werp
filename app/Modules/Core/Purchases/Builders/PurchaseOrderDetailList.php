<?php

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Main\MainList;

class PurchaseOrderDetailList extends MainList
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
                  'total_price' => 'Number',
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
                [
                  'key' => 'price',
                  'type' => 'amount',
                  'name' => 'price',
                  'id' => 'price',
                  'label' => 'Precio',
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
                  'endpoint' => '/admin/purchases/taxs',
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
                  'endpoint' => '/admin/purchases/discounts',
                  'required' => false,
                  'none' => true,
                ],              
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.purchases.orders')
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
              //['field' => 'tax', 'name' => 'Impuesto' , 'type' => 'amount'],
              //['field' => 'discount', 'name' => 'Descuento' , 'type' => 'amount'],
              //['field' => 'full_price', 'name' => 'Sub total' , 'type' => 'amount'],
              ['field' => 'total_price', 'name' => 'Total precio' , 'type' => 'amount', 'total' => true],
              ['field' => 'total_tax', 'name' => 'Total impuesto' , 'type' => 'amount', 'total' => true],
              ['field' => 'total_discount', 'name' => 'Total descuento' , 'type' => 'amount', 'total' => true],
              ['field' => 'total', 'name' => 'Total' , 'type' => 'amount', 'total' => true],
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