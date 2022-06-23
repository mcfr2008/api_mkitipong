<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::table('users', function (Blueprint $table) {
        //     $table->integer('votes');
        // });

        // Schema::table('students', function (Blueprint $table) {
        //     $table->text('subjects')->change();
        // });

        // Schema::rename($from, $to);

        // php artisan make:migration create_flights_table

        // php artisan migrate --path=/database/migrations/2021_03_13_125040_create_peoples_table.php  

        Schema::create('peoples', function (Blueprint $table) {

            // https://datastandard.m-society.go.th/codelist

                    
            $table->id()->comment('ไอดี');
            $table->integer('organization_id')->comment('องค์กร อ้างอิง organizations');
            // Serving หมายถึงการอยู่ในระหว่างรับราชการทหาร เช่น กำลังอยู่ในภาวะเป็นทหารเกณฑ์
            // Completed หมายถึงผ่านการเกณฑ์ทหารมาแล้วโดยการเป็นทหารเกณฑ์
            // Exempted หมายถึงได้รับการยกเว้นโดยการเรียน ร.ด.จบหลักสูตร หรือจับฉลากได้ใบดำ หรือร่างกายไม่ได้ขนาด หรือกำลังเป็นนักศึกษา
            $table->integer('military_status_id')->comment('สถานทางทหาร อ้างอิง militarys');

          
            // education_id การศึกษา การฝึกงาน
            // marital_status_id  สถานภาพสมรส
            // Career การทำงาน
            // Disability ความพิการ
            // Driving information ข้อมูลการขับขี่
           
            $table->boolean('registered_peoples_YN')->comment('สถานะ');
            $table->string('prefix_name', 255)->comment('คำนำหน้า');
            $table->string('first_name', 255)->comment('ชื่อ');
            $table->string('last_name', 255)->comment('นามสกุล');
            $table->string('nickname', 255)->comment('ชื่อเล่น');
            $table->string('gender', 55)->comment('เพศ');
            $table->string('blood_type', 55)->comment('กรุ๊ปเลือด');
            $table->date('birth_date')->comment('วันเกิด');
            $table->string('citizenid', 55)->comment('หมายเลขประจำตัวประชาชน');
            $table->string('nationality_name',255)->comment('สัญชาติ');
            $table->string('religion_name',255)->comment('ศาสนา');

            $table->string('country_address_detail_1', 255)->comment('ที่อยู่ภูมิลำเนา รายละเอียด 1');
            $table->string('country_address_detail_2', 255)->comment('ที่อยู่ภูมิลำเนา รายละเอียด 2');
            $table->string('country_address_district', 255)->comment('ที่อยู่ภูมิลำเนา อำเภอ');
            $table->string('country_address_province', 55)->comment('ที่อยู่ภูมิลำเนา จังหวัด');
            $table->string('country_address_postcode', 55)->comment('ที่อยู่ภูมิลำเนา รหัสไปรษณีย์');

            $table->string('current_address_detail_1', 255)->comment('ที่อยู่ปัจจุบัน รายละเอียด 1');
            $table->string('current_address_detail_2', 255)->comment('ที่อยู่ปัจจุบัน รายละเอียด 2');
            $table->string('current_address_district', 255)->comment('ที่อยู่ปัจจุบัน อำเภอ');
            $table->string('current_address_province', 55)->comment('ที่อยู่ปัจจุบัน จังหวัด');
            $table->string('current_address_postcode', 55)->comment('ที่อยู่ปัจจุบัน รหัสไปรษณีย์');

            $table->string('current_height', 55)->comment('ความสูงปัจจุบัน');
            $table->string('current_weight', 55)->comment('น้ำหนักปัจจุบัน');
            
            $table->integer('trash')->default('1')->comment('สถานะการใช้งาน 1 ใช้ 0 ไม่ใช้');

            // $table->integer('nationality_id')->comment('สัญชาติ อ้างอิง nationalitys');
            // $table->string('other_nationality', 55)->comment('อื่นๆ สัญชาติ');
            // $table->integer('religion_id')->comment('ศาสนา  อ้างอิง nationalitys');
            // $table->string('other_religion', 55)->comment('อื่นๆ ศาสนา ');

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
        Schema::dropIfExists('peoples');
    }
}
