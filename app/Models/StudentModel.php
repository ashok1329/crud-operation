<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StudentModel extends Model
{
    /**
    * @method: POST
    * @params: $request 
    * @returns: binary number(0,1)
    * @since: 18/02/2023
    * Comment: Create/Update record
    */
    public function addUpdateStudent($data,$stu_id) 
    {
        $response = 0;
        if($data)
        {
            if($stu_id)
            {
                 $response = DB::table('student')
                ->where('id', $stu_id)
                ->update($data);
            }
            else
            {
               $response = DB::table('student')->insert($data);
            }
        }
        return $response;
    }
    
    /* Fetching students records */
    public function getStudentList()
    {
        $response = (object)[];
        $list = DB::table('student')
        ->select('id','first_name','last_name','email','image','file_path')
        ->orderBy('id', 'DESC')
        ->get();
        if($list)
        {
          $response = $list;
        }
        return $response;
    }

    /**
    * @method: POST
    * @params: type (integer) $id
    * @returns: boolean
    * @since: 18/02/2023
    * Comment: Deleting record using id
    */
    public function deleteStudent($id)
    {
        $response = false;
        $del_student = DB::table('student')->where('id', $id)->delete();
        if($del_student)
        {
            $response=true;
        }
        return $response;
    }

    /**
    * @method: GET
    * @params: type (integer) $id
    * @returns: object
    * @since: 18/02/2023
    * Comment: Get specific record using id
    */
    public function findStudent($id)
    {
        $response = (object)[];
        $student_data = DB::table('student')
        ->select('id','first_name','last_name','email','image','file_path')
        ->where('id', $id)->first();
        if($student_data)
        {
            $response= $student_data;
        }
        return $response;
    }
}
