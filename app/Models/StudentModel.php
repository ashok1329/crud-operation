<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class StudentModel extends Model
{
    /* Adding student record */
     public function addUpdateStudent($data,$stu_id) {
        $response = [];
        if($data) {
            if($stu_id) {
                 $response = DB::table('student')
                ->where('id', $stu_id)
                ->update($data);
            } else {
               $response = DB::table('student')->insert($data);
            }
        }
        return $response;
    }
    
    /* Fetching students records */
    public function getStudentList() {
        $response = [];
        $list = DB::table('student')
        ->select('id','first_name','last_name','email','image','file_path')
        ->orderBy('id', 'DESC')
        ->get();
        if($list) {
          $response = $list;
        }
        return $response;
    }

    /*Delete student using Id*/
    public function deleteStudent($id) {
        $response = false;
        $del_student = DB::table('student')->where('id', $id)->delete();
        if($del_student) {
            $response=true;
        }
        return $response;
    }

    /*Get student data using id*/
    public function findStudent($id) {
        $response = (object)[];
        $student_data = DB::table('student')
        ->select('id','first_name','last_name','email','image','file_path')
        ->where('id', $id)->first();
        if($student_data) {
            $response= $student_data;
        }
        return $response;
    }
}
