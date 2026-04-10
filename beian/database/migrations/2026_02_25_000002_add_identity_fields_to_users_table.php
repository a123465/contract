<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentityFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('real_name')->nullable()->after('role');
            $table->string('id_number')->nullable()->after('real_name');
            $table->json('id_documents')->nullable()->after('id_number');
            $table->enum('id_status', ['unverified','verifying','verified','rejected'])->default('unverified')->after('id_documents');
            $table->timestamp('id_verified_at')->nullable()->after('id_status');
            $table->text('id_reject_reason')->nullable()->after('id_verified_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['real_name','id_number','id_documents','id_status','id_verified_at','id_reject_reason']);
        });
    }
}
