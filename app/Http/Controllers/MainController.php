<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StudentModel;
use DB;
use DataTables;

class MainController extends Controller
{
    /*Loading students view */
    public function loadStudent() {
        return view('list');
    }

    /* Adding student record */
    public function addRecord(Request $request) {
        
        $stu_id = $request->input('stu_id');
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:student',
            'email' => 'required|email|unique:student,email,'.$stu_id,
            'image' => 'mimes:jpeg,jpg,gif,png'
        ]);

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');

        $data = [
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                "email"=>$email,
                "created_at"=>NOW(),
                "updated_at"=>NOW()
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = '.'.$file->getClientOriginalExtension();
            
            $validate_extension = ['.jpg','.jpeg','.png'];

            if(in_array($extension, $validate_extension)) {
                $image=$file->getClientOriginalName();
                $destinationPath = public_path('/profile-image');
                $file->move($destinationPath,$image);    
                $data['image'] = $image;
                $data['file_path'] = "/profile-image";
            }
        }

        $student = new StudentModel;
        $response =  $student->addUpdateStudent($data,$stu_id);

        $msg = $stu_id!="" ? 'update' : 'create';

        if($response) {
            return redirect('/students')->with('msg', "You successfully $msg a student.");
        } else {
            return redirect('/add')->with('msg', "Something went wrong.");
        }
    }

    /* Fetching students records */
    public function studentsList(Request $request) {
        if ($request->ajax()) {
                $data =  StudentModel::getStudentList();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        //'.route('add',$row->id).'
                         $actionBtn = '<a href="/edit/'.$row->id.'" title="Edit User" class="btn btn-sm" style="color: #fff;background-color: #3DCB3A;border-color: #8ad3d3"> Edit </a> 
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Delete Student" onclick="deleteStudentRecord('.$row->id.')" >Delete</i></a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
    }

    /* Deleting student record using student id */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if($id && $id>0){
            $data = StudentModel::deleteStudent($id);
            return response()->json(['messege'=>'success'],200);
        } else {
            return redirect()->back();
        }
    }

    /*Get student data using id*/
    public function edit($id) {
        $user = StudentModel::findStudent($id);
        return view('add', compact('user'));
    }
}

