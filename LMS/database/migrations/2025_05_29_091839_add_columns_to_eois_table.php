<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   // In the new migration file
public function up()
{
    Schema::table('eois', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
        $table->string('name')->after('user_id');
        $table->string('email')->after('name');
        $table->text('project_details')->after('email');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('project_details');
        $table->text('admin_notes')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('eois', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id', 'name', 'email', 'project_details', 'status', 'admin_notes']);
    });
}
};
