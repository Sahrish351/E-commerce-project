<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'payment_receipt')) {
                $table->string('payment_receipt')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'card_last4')) {
                $table->string('card_last4')->nullable()->after('payment_receipt');
            }
            if (!Schema::hasColumn('orders', 'card_type')) {
                $table->string('card_type')->nullable()->after('card_last4');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_receipt', 'card_last4', 'card_type']);
        });
    }
};