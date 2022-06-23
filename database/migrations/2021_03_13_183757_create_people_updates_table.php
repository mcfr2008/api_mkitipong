<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // php artisan migrate --path=/database/migrations/2021_03_13_183757_create_people_updates_table.php 

        Schema::create('people_updates', function (Blueprint $table) {
            $table->id()->comment('ไอดี');
            $table->integer('people_id')->comment('ข้อมูลส่วนตัว อ้างอิง peoples');
            $table->date('date_received')->comment('วันที่');
            $table->string('subject', 255)->comment('หัวข้อ');
            $table->string('message', 255)->comment('ข้อความ');
            $table->string('other_details', 555)->comment('รายละเอียด');
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
        Schema::dropIfExists('people_updates');
    }
}
