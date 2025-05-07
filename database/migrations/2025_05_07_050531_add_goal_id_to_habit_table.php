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
        Schema::table('habits', function (Blueprint $table) {
            $table->unsignedBigInteger('goal_id')->nullable()->after('user_id');
            $table->string('strategy')->nullable()->after('name');

            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropForeign(['goal_id']);
            $table->dropColumn(['goal_id', 'strategy']);
        });
    }
};
