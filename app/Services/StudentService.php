<?php 
    namespace App\Services;

    use Illuminate\Http\Request;
    use App\Models\StudentModel;
    use DataTables;

    class StudentService
    {
        /**
        * @method: POST
        * @params: $request 
        * @returns: binary number(0,1)
        * @since: 18/02/2023
        * Comment: Create new record
        */
        public function create(Request $request)
        {
            $stu_id = $request->input('stu_id');
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:student',
                'email' => 'required|email|unique:student,email,'.$stu_id,
                'image' => 'mimes:jpeg,jpg,png'
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

            if ($request->hasFile('image')) 
            {
                $file = $request->file('image');
                $extension = '.'.$file->getClientOriginalExtension();
                
                $validate_extension = ['.jpg','.jpeg','.png'];

                if(in_array($extension, $validate_extension)) 
                {
                    $image=$file->getClientOriginalName();
                    $destinationPath = public_path('/profile-image');
                    $file->move($destinationPath,$image);    
                    $data['image'] = $image;
                    $data['file_path'] = "/profile-image";
                }
            }
            $student = new StudentModel;
            return $student->addUpdateStudent($data,$stu_id);
        }
        /**
        * @method: GET
        * @params: $request 
        * @returns: lists object
        * @since: 18/02/2023
        * Comment: Records Listings
        */
        public function list(Request $request)
        {
            if ($request->ajax()) 
            {
                $data =  StudentModel::getStudentList();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                         $actionBtn = '<a href="/edit/'.$row->id.'" title="Edit User" class="btn btn-sm" style="color: #fff;background-color: #3DCB3A;border-color: #8ad3d3"> Edit </a> 
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Delete Student" onclick="deleteStudentRecord('.$row->id.')" >Delete</i></a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        /**
        * @method: POST
        * @params: type (integer) $id
        * @returns: boolean
        * @since: 18/02/2023
        * Comment: Deleting record using id
        */
        public function delete($id)
        {
            return StudentModel::deleteStudent($id);
        }

        /**
        * @method: GET
        * @params: type (integer) $id
        * @returns: object
        * @since: 18/02/2023
        * Comment: Get specific record using id
        */
        public function edit($id)
        {
            return StudentModel::findStudent($id);
        }
    }
?>