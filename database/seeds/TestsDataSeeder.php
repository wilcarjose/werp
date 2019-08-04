<?php

use Werp\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Sales\Models\Tax;
use Werp\Modules\Core\Sales\Models\Discount;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Company;
use Werp\Modules\Core\Sales\Models\PriceListType;
use Werp\Modules\Core\Maintenance\Models\AmountOperation;

class TestsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amount1 = AmountOperation::create([
            'name'       => '+ 10%',
            'value'      => 10,
            'operation'  => 'add_percent',
            'round'      => 2,   
        ]);

        $tax1 = Tax::create([
            'name'                => 'Impuesto 10%',
            'amount_operation_id' => $amount1->id,
        ]);

        $amount2 = AmountOperation::create([
            'name'       => '- 15%',
            'value'      => 15,
            'operation'  => 'sub_percent',
            'round'      => 2,  
        ]);

        $discount1 = Discount::create([
            'name'                => 'Descuento 15%',
            'amount_operation_id' => $amount2->id,
        ]);

        $supplier = Partner::create([
            'name'          => 'Proveedor de Prueba',
            'document'      => '123456',
            'is_supplier'   => 'y',
            'type'          => Partner::SUPPLIER_TYPE,
        ]);

        $customer = Partner::create([
            'name'          => 'Cliente de Prueba',
            'document'      => '00000000',
            'is_customer'   => 'y',
            'type'          => Partner::CUSTOMER_TYPE,
        ]);

        $warehouse = Warehouse::create([
            'name'          => 'Almacén principal',
        ]);

        $product = Product::create([
            'code'          => '0001',
            'name'          => 'Producto de Prueba',
        ]);

        $product2 = Product::create([
            'code'          => '0002',
            'name'          => 'Producto de Prueba 2',
        ]);

        $product3 = Product::create([
            'code'          => '0003',
            'name'          => 'Producto de Prueba 3',
        ]);

        $listType = PriceListType::create([
            'name' => 'Lista de venta en dolares',
            'currency' => 'USD',
            'type' => 'sales',
        ]);
    }
}
