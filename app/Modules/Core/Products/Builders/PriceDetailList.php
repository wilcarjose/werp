<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class PriceDetailList extends MainList
{
    public function __construct($empty = false, $filter = null, $disable = false)
    {
        $modal = [
              'object' => ['id' => 'Number', 'product_id' => 'Number', 'price' => 'Float'],
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
                  'key' => 'price',
                  'type' => 'text',
                  'name' => 'price',
                  'id' => 'price',
                  'label' => 'Precio',
                ]
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.products.prices')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields(['product_name' => 'Producto', 'price' => 'Precio'])
            ->setFilter($filter)
            ->setEmptyList($empty)
            ->setPaginate(false)
            ->setDisable($disable)
            ->setModalConfig($modal)
            ->makeConfig();

        parent::__construct();
    }
}