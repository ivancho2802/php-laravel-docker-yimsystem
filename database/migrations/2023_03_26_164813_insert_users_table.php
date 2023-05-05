<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InsertUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $password = Hash::make('12345678');

        DB::table('users')->insertOrIgnore(
            array(
                'name'=>'testname',
                'email'=>'test@yimsystem.com',
                'password'=>$password,
                'nivel'=>1
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
        //
    }
}
