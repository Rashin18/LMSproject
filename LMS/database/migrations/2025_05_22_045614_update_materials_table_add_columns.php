<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('materials', function (Blueprint $table) {
        $table->string('subject')->nullable()->after('title');
        //$table->string('type')->default('video')->after('file_path'); // video, pdf, assignment
        //$table->unsignedInteger('download_count')->default(0)->after('type');
    });
}

public function down()
{
    Schema::table('materials', function (Blueprint $table) {
        $table->dropColumn(['subject'/*, 'type', 'download_count'*/]);
    });
}
};
