<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUpdateidColumnInMediaTable extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->renameColumn('updateID', 'updateid');
        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->renameColumn('updateid', 'updateID');
        });
    }
}
