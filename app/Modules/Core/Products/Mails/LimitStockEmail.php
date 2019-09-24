<?php

namespace Werp\Modules\Core\Products\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LimitStockEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    protected $qty;
    protected $max_min_qty;
    protected $min;
    protected $warehouse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product, $qty, $max_min_qty, $min = true, $warehouse = null)
    {
        $this->product = $product;
        $this->qty = $qty;
        $this->max_min_qty = $max_min_qty;
        $this->min = $min;
        $this->warehouse = $warehouse;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            //->from([env('mail.from.address')])
            ->subject('Notificación de Stock')
            ->markdown('admin.core.products.emails.limit-stock')
            ->with([
                'product' => $this->product,
                'qty' => $this->qty,
                'max_min_qty' => $this->max_min_qty,
                'min' => $this->min,
                'warehouse' => $this->warehouse
            ]);
    }
}
