<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('application_token')->nullable()->after('status');
            $table->timestamp('token_expires_at')->nullable()->after('application_token');
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['application_token', 'token_expires_at']);
        });
    }
};