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
        Schema::create('r_course_events', function (Blueprint $table) {
            $table->id('course_events_id');
            $table->date('register_start');
            $table->date('register_end');
            $table->date('execution');
            $table->boolean('status');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('created_by'))->references('user_id')->on('d_user');
            $table->foreign(('updated_by'))->references('user_id')->on('d_user');
            $table->foreign(('deleted_by'))->references('user_id')->on('d_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_course_events');
    }
};
