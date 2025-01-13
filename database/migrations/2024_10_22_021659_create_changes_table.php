<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->id(); // Primary Key (bigint)
            $table->foreignId('application_id')->constrained()->onDelete('cascade'); // Pastikan tipe data sama (bigint)
            $table->string('perubahan');
            $table->enum('tingkat_kepentingan', ['Normal', 'Mendesak']);
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->date('uat_date')->nullable();
            $table->date('release_date')->nullable();
            $table->string('version');
            $table->date('target_release_date')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changes');
    }
}