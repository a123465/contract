<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('content_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewable_type', 50);
            $table->unsignedBigInteger('reviewable_id');
            $table->unsignedBigInteger('reporter_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->enum('status', ['pending', 'auto-flagged', 'approved', 'rejected', 'removed'])->default('pending');
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable();
            $table->json('auto_checks')->nullable();
            $table->json('action')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['reviewable_type', 'reviewable_id']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_reviews');
    }
}
