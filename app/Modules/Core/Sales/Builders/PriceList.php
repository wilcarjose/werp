<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Main\MainList;

class PriceList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              'object' => ['id' => 'Number', 'product_id' => 'Number', 'price' => 'Number'],
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
                  'none' => true,
                  'endpoint' => '/admin/products/products'
                ],
                [
                  'key' => 'price',
                  'type' => 'amount',
                  'name' => 'price',
                  'id' => 'price',
                  'label' => 'Precio',
                ]
              ],
              'advanced_fields' => [
                [
                  'key' => 'all',
                  'type' => 'check',
                  'name' => 'all',
                  'id' => 'all',
                  'label' => 'Todos',
                ],
            /*    [
                  'key' => 'stock',
                  'type' => 'check',
                  'name' => 'stock',
                  'id' => 'stock',
                  'label' => 'Existencia > 0',
                ],
                [
                  'key' => 'warehouses',
                  'type' => 'select',
                  'name' => 'warehouse_id',
                  'id' => 'warehouses',
                  'items' => 'warehouses',
                  'label' => 'Por almacén',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'none' => true,
                  'endpoint' => '/admin/products/warehouses'
                ],
                [
                  'key' => 'categories',
                  'type' => 'select',
                  'name' => 'category_id',
                  'id' => 'categories',
                  'items' => 'categories',
                  'label' => 'Por categoría',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'none' => true,
                  'endpoint' => '/admin/products/categories'
                ],
                [
                  'key' => 'brands',
                  'type' => 'select',
                  'name' => 'brand_id',
                  'id' => 'brands',
                  'items' => 'brands',
                  'label' => 'Por marca',
                  'id_key' => 'id',
                  'value_key' => 'name',
                  'none' => true,
                  'endpoint' => '/admin/products/brands'
                ],
                */
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.sales.price_lists')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(true)
            ->setShowMessages(false)
            ->setShowAdvancedOptions(true)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text', 'link' => true], 
              ['field' => 'before_price', 'name' => 'Precio anterior' , 'type' => 'amount'],
              ['field' => 'base_price', 'name' => 'Precio base' , 'type' => 'amount'],
              ['field' => 'operation_name', 'name' => 'Operación' , 'type' => 'text'],
              ['field' => 'price', 'name' => 'Precio final' , 'type' => 'amount'],
              ['field' => 'currency_abbr', 'name' => 'Moneda' , 'type' => 'text']
            ])
            ->setFilter($filter)
            ->setEmptyList($empty)
            ->setPaginate(false)
            ->setDisable($disable)
            ->setModalConfig($modal)
            ->setShowActions(false)
            ->setMoreOptions('Cargar más productos')
            ->setReloadOnSave(true)
            ->makeConfig();

        parent::__construct();
    }
}