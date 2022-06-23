<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // php artisan migrate --path=/database/migrations/2021_03_14_104117_create_educations_table.php

        Schema::create('educations', function (Blueprint $table) {

            $table->id()->comment('ไอดี');
            $table->integer('people_id')->comment('ข้อมูลส่วนตัว อ้างอิง peoples');
            $table->string('level', 255)->comment('ระดับการศึกษา');
            $table->string('degree', 255)->comment('วุฒิการศึกษา');
            $table->string('branch', 255)->comment('สาขา');
            $table->string('faculty', 255)->comment('คณะ');
            $table->string('academy', 255)->comment('สถานศืกษา');
            $table->string('gpa', 55)->comment('เกรดเฉลี่ย');
            $table->date('graduation_date')->comment('วัน/เดือน/ปี ที่จบการศึกษา');
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
        Schema::dropIfExists('educations');
    }
}
