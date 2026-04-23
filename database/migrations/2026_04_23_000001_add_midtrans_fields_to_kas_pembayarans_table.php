<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kas_pembayarans', function (Blueprint $table) {
            $table->string('order_id')->nullable()->index();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('fraud_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->text('payment_url')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('settlement_time')->nullable();
            $table->json('midtrans_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_pembayarans', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropColumn([
                'order_id',
                'transaction_id',
                'transaction_status',
                'fraud_status',
                'payment_type',
                'payment_url',
                'snap_token',
                'bank',
                'va_number',
                'transaction_time',
                'settlement_time',
                'midtrans_response',
            ]);
        });
    }
};
