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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',30)->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('phone');
            $table->date('birthday')->nullable()->after('bio');
            $table->string('gender',16)->nullable()->after('birthday');
            $table->string('occupation',120)->nullable()->after('gender');
            $table->string('hometown',120)->nullable()->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone','bio','birthday','gender','occupation','hometown']);
        });
    }
};
