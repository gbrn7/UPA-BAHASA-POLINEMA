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
        Schema::create('t_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id')->index();
            $table->string('nim');
            $table->string('name');
            $table->string('email');
            $table->string('no_telepon');
            $table->string('departement');
            $table->string('program_study');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('activity_id'))->references('activity_id')->on('r_activity');
            $table->foreign(('created_by'))->references('activity_id')->on('t_registrations');
            $table->foreign(('updated_by'))->references('activity_id')->on('t_registrations');
            $table->foreign(('deleted_by'))->references('activity_id')->on('t_registrations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_registrations');
    }
};
