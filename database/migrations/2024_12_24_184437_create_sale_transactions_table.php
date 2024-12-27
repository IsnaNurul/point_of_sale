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
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->integer('total_qty')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('sub_total')->default(0);
            $table->integer('discount')->default(0)->nullable();
            $table->string('status')->default('');
            $table->foreignId('discountId')->nullable()->constrained('discounts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('customerId')->nullable()->constrained('customers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('cashierId')->nullable()->constrained('cashiers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_transactions');
    }
};
