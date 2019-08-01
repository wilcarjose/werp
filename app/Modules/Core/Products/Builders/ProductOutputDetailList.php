<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class ProductOutputDetailList extends MainList
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
                  'endpoint' => '/admin/products/products',
                  'required' => true,
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
                  'key' => 'amount',
                  'type' => 'amount',
                  'name' => 'amount',
                  'id' => 'amount',
                  'label' => 'Precio',
                  'required' => true,
                ],

              ],
                
              'advanced_fields' => [
                [
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
                ],
              
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.products.product_output')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text'],
              ['field' => 'warehouse_name', 'name' => 'Almacén' , 'type' => 'text'], 
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