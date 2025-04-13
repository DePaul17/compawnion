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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
            $table->string("name");
            $table->string("first_name");
            $table->date("date_of_birth");
            $table->json("address");
            $table->string("type_client");
            $table->string("identity_document")->nullable();
            $table->string("picture")->nullable();
            $table->string("attestation")->nullable();
            $table->string("petsitter_certificate_acaced")->nullable();
            $table->string("verificate")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
