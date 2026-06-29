<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // ✅ Rename address to address_line1
            if (Schema::hasColumn('addresses', 'address')) {
                $table->renameColumn('address', 'address_line1');
            }
            
            // ✅ Add address_line2
            if (!Schema::hasColumn('addresses', 'address_line2')) {
                $table->string('address_line2')->nullable()->after('address_line1');
            }
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'address_line1')) {
                $table->renameColumn('address_line1', 'address');
            }
            if (Schema::hasColumn('addresses', 'address_line2')) {
                $table->dropColumn('address_line2');
            }
        });
    }
};