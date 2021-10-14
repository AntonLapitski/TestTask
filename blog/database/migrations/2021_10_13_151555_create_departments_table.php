<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id')->unsigned()->unique();;
            $table->string('name');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('departments')->insert(
            array(
                'name' => 'testDivision1'
            )
        );

        \Illuminate\Support\Facades\DB::table('departments')->insert(
            array(
                'name' => 'testDivision2'
            )
        );

        \Illuminate\Support\Facades\DB::table('departments')->insert(
            array(
                'name' => 'testDivision3'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
