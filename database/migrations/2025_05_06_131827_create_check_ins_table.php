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
	    Schema::create('check_ins', function (Blueprint $table) {
		    $table->id();
		    $table->foreignId('user_id')->constrained()->onDelete('cascade');
		    $table->text('answer');
		    $table->text('ai_response')->nullable();
		    $table->string('mood')->nullable(); // could be added for mood tracking
		    $table->date('date')->nullable(); // date of the check-in
		    $table->timestamps();
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
