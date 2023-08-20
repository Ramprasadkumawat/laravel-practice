<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class HomeController extends Controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use DB;


class HomeController extends Controller
{
    public function createDB()
    {
        try{
            $new_db_name = "DB_".rand()."_".time();
            $new_mysql_username = "root";
            $new_mysql_password = "";

            $conn = mysqli_connect(
                config('database.connections.mysql.host'), 
                env('DB_USERNAME'), 
                env('DB_PASSWORD')
            );
            if(!$conn ) {
                return false;
            }
            $sql = 'CREATE Database IF NOT EXISTS '.$new_db_name;
            $exec_query = mysqli_query( $conn, $sql);
            if(!$exec_query) {
                die('Could not create database: ' . mysqli_error($conn));
            }
            return 'Database created successfully with name '.$new_db_name;
        }
        catch(\Exception $e){
            return false;
        }
    }
    
    
    public function getDB()
    {
        $db = 'db_247720736_1687741406';

        Config::set('database.connections.mysql.database', $db);

        DB::disconnect('mysql');

        DB::reconnect('mysql');

        $data = DB::table('products')->get();

        Config::set('database.connectons.mysql.databse', 'original_databse');

        dd($data);
    }

//  curl -X POST -H "Content-Type: application/json" 
// --data '{"names": "Make a cake" }' http://10.10.0.10:8880/api/v1/addTask
// {"response":"Added Make a cake to tasks."}
//  curl http://10.10.0.10:8880/api/v1/getTasks
// [
//     {"id":7,"names":"Grocery shopping","created_at":"2016-05-12 06:18:46","updated_at":"2016-05-12 06:18:46"},
//     {"id":8,"names":"Dry cleaning","created_at":"2016-05-12 06:18:52","updated_at":"2016-05-12 06:18:52"},
//     {"id":13,"names":"Car wash","created_at":"2016-05-12 09:51:01","updated_at":"2016-05-12 09:51:01"},
//     {"id":23,"names":"Make a cake","created_at":"2016-06-24 07:13:21","updated_at":"2016-06-24 07:13:21"}
// ]
}
