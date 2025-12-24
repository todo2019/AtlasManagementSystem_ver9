<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['over_name'=>'登藤',
            'under_name'=>'拓海',
            'over_name_kana'=>'トドウ',
            'under_name_kana'=>'タクミ',
            'mail_address'=>'main@main',
            'sex'=>'1',
            'birth_day'=>'1998-09-08',
            'role'=>'1',
            'password'=>'todo199809']
        ]);
    }
}
