@extends('common/layout')
@section('title', 'Add Page')
@section('content')
<div class="container">
    <div class="row">
        <h2>Student Add form</h2>


{{isset($field) ? @route('field.updated', $field->id) : @route('field.store')}}
        <form action="{{ url('add-student') }}" method="post" enctype="multipart/form-data" id="add-student-form">    
          @csrf
          <div class="form-group">
            <label for="name">First Name:</label>

            {{old('name', $profile->name)}}
            <input type="text" class="form-control" id="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" name="first_name">
            @if ($errors->has('first_name'))
                <span class="text-danger">{{ $errors->first('first_name') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" name="last_name">
            @if ($errors->has('last_name'))
                <span class="text-danger">{{ $errors->first('last_name') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" value="{{old('email')}}" placeholder="Enter email address" name="email">
            @if ($errors->has('email'))
                <span class="text-danger" id="email-error">{{ $errors->first('email') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="pwd">Upload Profile Image:</label>
            <input type="file" class="form-control" id="image" value="{{ old('image') }}" name="image">
            @if ($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
            @endif
          </div>
          <button id="add-student" type="button" class="btn btn-success">Add</button>
        </form>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on("click", "#add-student", function(){
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var emailPattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        
        if(first_name == "") {
            var emsg = 'The first name field is required.';
            checkValidate('first_name',emsg);
        } else if (last_name == "") {
            var emsg = 'The last name field is required.';
            checkValidate('last_name',emsg);
        } else if(email == "") {
            var emsg = 'The email field is required.';
            checkValidate('email',emsg);
        }
        else if(!emailPattern.test(email)) {
            var emsg = 'Not a valid email address.';
            checkValidate('email',emsg);
        }
        else {
            $("#add-student-form").submit();
            return true;
        }
    });
    
    function checkValidate(field_name,msg) {
        $(".text-danger").remove();
        if(field_name !="" && msg !="") {
            $('#'+field_name).after("<span class='text-danger'>"+msg+"</span>");
            return false;
        }
    }
</script>
@endsection


/* Fetching students records */
    // public function studentsList(Request $request) {
    //     $keyword = $request->input('keyword');
    //     $student = new StudentModel;
    //     $list =  $student->getStudentList($keyword);
    //     // echo "<pre>";
    //     // print_r($list);
    //     // die();
    //     if($request->input('from') == "ajax") {
    //         $response = ['status' => 'success','list' => $list];
    //         return response()->json($response);
    //     } else{
    //         return view("list", ["list"=>$list]);
    //     }
    // }
}

/* Students fetching from database */
//Route::get('/list', [MainController::class, 'studentsList']);
Route::get('/problems/{problem-id}/edit', ['as' => 'problems.edit', 'uses' => 'AdminController@editProblem']);

// Route::get('/list', function () {
//     return view('list');
// });

//Route::get('/search', [MainController::class, 'studentsList']);
//Route::get('/saveToken', [FcmController::class, 'saveToken']);
Route::post('/search', [MainController::class, 'studentsList'])->name('studentsList');