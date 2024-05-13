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
            $table->unsignedBigInteger('course_events_id')->index();
            $table->unsignedBigInteger('course_type_id')->index();
            $table->integer('quota');
            $table->integer('remaining_quota');
            $table->string('day_name');
            $table->time('time_start');
            $table->time('time_end');
            $table->boolean('status');
            $table->string('information')->nullable();
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('course_events_id'))->references('course_events_id')->on('r_course_events');
            $table->foreign(('course_type_id'))->references('course_type_id')->on('m_course_type');
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
