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
		Schema::table('users', function (Blueprint $table) {
			$table->boolean('is_first_login')->default(true);
			$table->boolean('setup_completed')->nullable()->after('email');
		});
	}
	
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('is_first_login');
			$table->dropColumn('setup_completed');
		});
	}
};
