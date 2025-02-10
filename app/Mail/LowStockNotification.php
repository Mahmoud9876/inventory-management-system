<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Product;

class LowStockNotification extends Mailable
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        return $this->subject('⚠️ Alerte Stock Faible : ' . $this->product->name)
                    ->view('emails.lowStockAlert')
                    ->with(['product' => $this->product]);
    }
}
