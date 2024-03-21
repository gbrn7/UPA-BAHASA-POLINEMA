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
            $table->id('registration_id');
            $table->unsignedBigInteger('event_id')->index();
            $table->string('name');
            $table->string('nim');
            $table->string('nik');
            $table->string('departement');
            $table->string('program_study');
            $table->string('semester');
            $table->string('email');
            $table->string('phone_num');
            $table->string('ktp_img');
            $table->string('ktm_img');
            $table->string('surat_pernyataan_iisma');
            $table->string('pasFoto_img');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('event_id'))->references('event_id')->on('r_events');
            $table->foreign(('created_by'))->references('event_id')->on('t_registrations');
            $table->foreign(('updated_by'))->references('event_id')->on('t_registrations');
            $table->foreign(('deleted_by'))->references('event_id')->on('t_registrations');
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
