<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StudentService;

class MainController extends Controller
{
    /**
    * @method: GET
    * @params:  
    * @returns: 
    * @since: 18/02/2023
    * Comment: Loading student view
    */
    public function loadStudent() 
    {
        return view('list');
    }

    /**
    * @method: POST
    * @params: $request 
    * @returns: redirect to list or add 
    * @since: 18/02/2023
    * Comment: Add record
    */
    public function addRecord(Request $request, StudentService $studentService) 
    {
        $response = $studentService->create($request);
        $msg = $request->input('stu_id')!="" ? 'update' : 'create';
        if($response) 
        {
            return redirect('/')->with('msg', "You successfully $msg a student.");
        } 
        else 
        {
            return redirect('/add')->with('msg', "Something went wrong.");
        }
    }

    /**
    * @method: GET
    * @params: $request 
    * @returns: lists object
    * @since: 18/02/2023
    * Comment: Records Listings
    */
    public function studentsList(Request $request, StudentService $studentService) 
    {
       return $studentService->list($request);
    }

    /**
    * @method: POST
    * @params: type (integer) $id
    * @returns: boolean
    * @since: 18/02/2023
    * Comment: Deleting record using id
    */
    public function destroy(Request $request, StudentService $studentService)
    {
        $id = $request->input('id');
        $response = redirect()->back();
        if($id && $id>0)
        {
            $data = $studentService->delete($id);
            if($data)
            {
                $response = response()->json(['messege'=>'success'],200);
            }
            else 
            {
                $response = redirect()->back();     
            }
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
    public function edit($id, StudentService $studentService) 
    {
        $user = (object)[];
        if($id && $id>0)
        {
            $user = $studentService->edit($id);
        }
        return view('add', compact('user'));
    }
}