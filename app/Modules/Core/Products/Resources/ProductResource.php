<?php

namespace Werp\Modules\Core\Products\Resources;

use Werp\Modules\Core\Base\Resources\BaseResource;

class ProductResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when($this->show('id'), $this->id),
            'code' => $this->when($this->show('code'), $this->code),
            'name' => $this->when($this->show('name'), $this->name),
            'part_number' => $this->when($this->show('part_number'), $this->part_number),
            'barcode' => $this->when($this->show('barcode'), $this->barcode),
            'qrcode' => $this->when($this->show('qrcode'), $this->qrcode),
            'link' => $this->when($this->show('link'), $this->link),
            'image' => $this->when($this->show('image'), '/images/products/img1.jpg'), //$this->image,
            'is_service' => $this->when($this->show('is_service'), $this->is_service),
            'brand_id' => $this->when($this->show('brand_id'), $this->brand_id),
            'partner_id' => $this->when($this->show('partner_id'), $this->partner_id),
            'description' => $this->when($this->show('description'), $this->description),
            'category_id' => $this->when($this->show('category_id'), $this->category_id),
            'uom_id' => $this->when($this->show('uom_id'), $this->uom_id),
            'active' => $this->when($this->show('active'), $this->active),
            'created_at' => $this->when($this->show('created_at'), $this->created_at),
            'price' => $this->when($this->show('price'), 456324),
            'ml_enabled' => $this->when($this->show('ml_enabled'), $this->ml_enabled),  // ML
            'ml_item_id' => $this->when($this->show('ml_item_id'), $this->ml_item_id),  // ML
        ];
    }    
}
