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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->json("general_objectives");
            $table->json("specific_objectives");
            $table->enum("project_type", ["INVESTIGACIÓN", "INNOVACIÓN", "EXTENSIÓN", "EMPRENDIMIENTO"]);
            $table->enum("project_status", ["EN_CURSO", "FINALIZADO", "PENDIENTE"]);
            $table->foreignId("manager")->constrained("users", "id");
            $table->timestamp("start_date")->default(now());
            $table->timestamp("end_date")->nullable();
            $table->string("project_link");
            $table->string("portrait_url");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
