<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharismasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Special
        // php artisan migrate --path=/database/migrations/2021_03_13_182852_create_charismas_table.php  

        Schema::create('charismas', function (Blueprint $table) {
            $table->id()->comment('ไอดี');
            $table->integer('people_id')->comment('ข้อมูลส่วนตัว อ้างอิง peoples');
            $table->string('name', 255)->comment('ชื่อ');
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
        Schema::dropIfExists('charismas');
    }
}
