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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->string("title");
            $table->text("description");
            $table->enum("activity_type", ["online", "in-person"]);
            $table->string("link")->nullable();
            $table->string("location")->nullable();
            $table->dateTime("start_date");
            $table->dateTime("end_date")->nullable();
            $table->integer("duration");
            $table->string("color");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
