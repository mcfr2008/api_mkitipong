<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         // php artisan migrate --path=/database/migrations/2021_03_13_173331_create_organizations_table.php  

        Schema::create('organizations', function (Blueprint $table) {
            $table->id()->comment('ไอดี');
            $table->string('name', 255)->comment('ชื่อ');
            $table->string('address', 255)->comment('ที่อยู่');
            $table->string('other_details', 555)->comment('รายละเอียด');
            $table->integer('trash')->default('1')->comment('สถานะของไอดี 1 ใช้งาน 0 ไม่ใช้งาน');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
