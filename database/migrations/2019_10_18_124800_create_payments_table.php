<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Werp\Modules\Core\Maintenance\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Payment;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('transaction_number')->nullable();
            $table->timestamp('date');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->double('amount', 20, 4)->default(0.0000);
            $table->uuid('currency_id');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
            $table->enum('card_type',[Payment::DEBIT_CARD, Payment::CREDIT_CARD])->nullable();
            $table->enum('type',[Payment::PAYMENT_TYPE, Payment::RECEIPT_TYPE])->default(Payment::RECEIPT_TYPE);
            $table->string('state', 2)->default(Basedoc::PE_STATE);
            $table->uuid('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
            $table->uuid('doctype_id');
            $table->foreign('doctype_id')
                ->references('id')
                ->on('doctypes');
            $table->uuid('invoice_id')->nullable();
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');
            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')
                ->references('id')
                ->on('banks');
            $table->uuid('bank_account_id')->nullable();
            $table->foreign('bank_account_id')
                ->references('id')
                ->on('bank_accounts');
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->uuid('payment_method_id');
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
