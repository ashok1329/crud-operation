@extends('common/layout')
@section('title', 'List Page')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Students Listing</h2>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
  $(function () {
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'image', name: 'image',
            render: function( data, type, full, meta ) {
                if(data) {
                    $img = "<img src=\"/profile-image/" + data + "\" height=\"150\"                 alt='No Image'/>";
                } else {
                    $img = "<img src='/profile-image/no-Image.png' height=\"150\"                 alt='No Image'/>";
                }
                return $img;
            }
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
  });

  function deleteStudentRecord(id) {
    if(id !="") {
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
          swal({
          title: "Are you sure?",
          text: "You will not be able to recover this student!",
          icon: "warning",
          buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
          ],
          dangerMode: true,
        }).then((result) => {
              if (result) {
                  $.ajax({
                      url    : "destroy",
                      type   : "POST",
                      data: {"_token": "{{ csrf_token() }}", id:id},
                      success: function(data) {
                        $('.yajra-datatable').DataTable().ajax.reload();
                      }
                  })
              }
          })
    }
  }
</script>
@endsection