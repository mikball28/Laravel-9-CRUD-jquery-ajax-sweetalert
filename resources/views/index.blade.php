<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel JQUERY-AJAX CRUD KULLANIMI</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <link href="https://fonts.cdnfonts.com/css/cascadia-code" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            
    </head>
    <body>
    {{-- Öğrenci Ekle Modal --}}
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Öğrenci Ekle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_student_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">Ad</label>
              <input type="text" name="fname" class="form-control" placeholder="Ad " required>
            </div>
            <div class="col-lg">
              <label for="lname">Soyad</label>
              <input type="text" name="lname" class="form-control" placeholder="Soyad" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="number">Numara</label>
            <input type="tel" name="number" class="form-control" placeholder="Numara" required>
          </div>
          <div class="my-2">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          <button type="submit" id="add_student_btn" class="btn btn-success">Öğrenci Ekle</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Öğrenci Ekle Modal Son --}}

{{-- Öğrenci Güncelle Modal --}}
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Öğrenci Güncelle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_student_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="emp_id" id="student_id">
        <input type="hidden" name="emp_avatar" id="student_avatar">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">Ad</label>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="Ad " required>
            </div>
            <div class="col-lg">
              <label for="lname">Soyad</label>
              <input type="text" name="lname" id="lname" class="form-control" placeholder="Soyad" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
          </div>
          <div class="my-2">
            <label for="phone">Numara</label>
            <input type="tel" name="number" id="number"  class="form-control" placeholder="Numara" required>
          </div>
          <div class="my-2">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
        </div>
        <div id="avatar" class="mt-2">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          <button type="submit" id="edit_student_btn" class="btn btn-warning text-light">Öğrenci Güncelle</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Öğrenci Güncelle Modal Son --}}

<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-11">
        <div class="card shadow">
          <div class="card-header  d-flex justify-content-between align-items-center">
            <h5 class="text-dark">Öğrenciler</h5>
            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fa fa-check  me-1"></i>Öğrenci Ekle</button>
          </div>
          <div class="card-body text-center" id="show_all_student">
            <h3 class="text-center text-secondary my-5">Yükleniyor...</h3>
          </div>
        </div>
      </div>
    </div>
  </div>



        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            //fetch all students ajax request
            


            function fetchAllStudent(){
              $.ajax({
                url:'{{route('fetchall')}}',
                method:'get',
                success:function(res){
                  $("#show_all_student").html(res);
                  $("table").DataTable({
                    order:[0,'asc']
                    

                  });

                }

              });
            }
            //Öğrenci Güncelle
            $("#edit_student_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_student_btn").text('Güncelleniyor...');
            $.ajax({
              url: '{{ route('update') }}',
              method: 'post',
              data: fd,
              cache: false,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
                if (response.status == 200) {
                  Swal.fire(
                    'Güncellendi!',
                    'Öğrenci Başarıyla Güncellendi!',
                    'success'
                  )
                  fetchAllStudent();
                }
                $("#edit_student_btn").text('Öğrenci Güncelle');
                $("#edit_student_form")[0].reset();
                $("#editStudentModal").modal('hide');
              }
            });
          });

          //delete
          $(document).on('click', '.deleteIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          let csrf = '{{ csrf_token() }}';
          Swal.fire({
            title: 'Eminmisiniz?',
            text: "Silinen verileri geri alamazsınız!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!'
             }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: '{{ route('delete') }}',
                method: 'delete',
                data: {
                  id: id,
                  _token: csrf
                },
                success: function(response) {
                  console.log(response);
                  Swal.fire(
                    'Silindi!',
                    'Veriniz silindi!',
                    'success'
                  )
                  fetchAllStudent();
                }
              });
            }
          })
        });



            //Öğrenci Edit
            $(document).on('click','.editIcon',function(e){
                e.preventDefault();
                let id=$(this).attr('id');
                $.ajax({
                  url:'{{route('edit')}}',
                  method:'get',
                  data:{
                    id:id,
                    _token:'{{ csrf_token()}}',

                  },
                  success:function(res){
                    $("#fname").val(res.name);
                    $("#lname").val(res.surname);
                    $("#email").val(res.email);
                    $("#number").val(res.number);
                    $("#avatar").html('<img src="public/images/${res.avatar}" width="100" class="img-fluid img-thumbnail">');
                    $("#student_id").val(res.id);
                    $("#student_avatar").val(res.avatar);
                    
                  }

                });
            });

            //yeni öğrenci ajax request ekle
            $("#add_student_form").submit(function(e){
                e.preventDefault();
                const fd=new FormData(this);
                $("#add_student_btn").text("Ekleniyor...");
                $.ajax({
                    url:'{{route('store')}}',
                    method:'post',
                    data:fd,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success:function(res){
                        if(res.status==200){
                          swal.fire(
                            'Eklendi!',
                            'Öğrenci Başarılı Bir Şekilde Eklendi!',
                            'success'
                          )
                          fetchAllStudent();
                        }
                        $("#add_student_btn").text('Öğrenci Ekle');
                        $("#add_student_form")[0].reset();
                        $("#addStudentModal").modal('hide');
                    }
                });

                

            });
        </script>

    </body>
</html>
