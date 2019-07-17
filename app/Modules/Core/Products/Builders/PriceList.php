<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

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
                  'endpoint' => '/admin/products/products'
                ],
                [
                  'key' => 'price',
                  'type' => 'amount',
                  'name' => 'price',
                  'id' => 'price',
                  'label' => 'Precio',
                ]
              ]
           ];

        $this->setTitle('Productos')
            ->setRoute('admin.products.price_lists')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields([
              ['field' => 'product_name', 'name' => 'Producto' , 'type' => 'text'], 
              ['field' => 'price', 'name' => 'Precio' , 'type' => 'amount']
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