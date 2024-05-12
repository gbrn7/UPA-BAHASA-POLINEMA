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
        Schema::create('r_course_event_schedule', function (Blueprint $table) {
            $table->id('course_event_schedule_id');
            $table->unsignedBigInteger('course_event_type_course_id')->index();
            $table->integer('quota');
            $table->integer('remaining_quota');
            $table->string('day_name');
            $table->string('time_start');
            $table->string('time_end');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('course_event_type_course_id'))->references('course_event_type_course_id')->on('r_course_event_type_course');
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
        Schema::dropIfExists('r_course_event_schedule');
    }
};
