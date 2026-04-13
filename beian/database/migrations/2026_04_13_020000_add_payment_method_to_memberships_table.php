<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('memberships', 'payment_method')) {
            Schema::table('memberships', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->after('expires_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('memberships', 'payment_method')) {
            Schema::table('memberships', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
