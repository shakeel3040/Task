@extends('admin.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <!-- /.card -->
<!-- Button trigger modal -->



            <div class="card">
              <div class="card-header">
              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right">Add Category</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @php 
                        $counter=1;
                    @endphp
                  @foreach ($data as $category)
                 
           
                  <tr data-id="{{ $category->id }}">
                    <td>{{$counter;  }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                    <a href="javascript:void(0);" class="edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="delete-category" data-id="{{ $category->id }}">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
                    
                  </tr>
                  @php
                       $counter++;
                 @endphp
                  @endforeach
                 
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Sr No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="success_alert"></span>
        <form id="addCategoryForm">
          <div class="form-group">
            <label for="categoryName">Category Name</label>
            <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter category name">
            <span id="error_message"></span>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCategory">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Update Category Modal -->
<div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="updateCategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCategoryLabel">Update Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="update_success_alert"></span>
        <form id="updateCategoryForm">
          <div class="form-group">
            <label for="updateCategoryName">Category Name</label>
            <input type="text" class="form-control" id="updateCategoryName" name="category_name" placeholder="Enter category name">
            <input type="hidden" id="updateCategoryId"> <!-- Hidden input to store category ID -->
            <span id="update_error_message"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateCategory">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script>
   $(document).ready(function () {
  
    $('#saveCategory').on('click', function (e) {
        e.preventDefault();
        $('#error_message').html(''); 

        var categoryName = $('#categoryName').val(); 

        $.ajax({
            url: "{{ route('categories.store') }}",  
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}", 
                category_name: categoryName
            },
            success: function (response) {
                $('#exampleModal').modal('hide');  
                $('#categoryName').val(''); 
                $('#success_alert').html(`<div class="alert alert-success">${response.success}</div>`); // Show success message
                
                var newRow = `
                    <tr data-id="${response.category.id}">
                        <td>${$('#example1 tbody tr').length + 1}</td>
                        <td>${response.category.name}</td>
                        <td>
                            <a href="javascript:void(0);" class="edit-category" data-id="${response.category.id}" data-name="${response.category.name}"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);" class="delete-category" data-id="${response.category.id}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                `;
                $('#example1 tbody').append(newRow); 
            },
            error: function (xhr) {
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    $('#error_message').html(`<span class="text-danger">${xhr.responseJSON.error}</span>`);
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = errors.category_name ? errors.category_name[0] : 'An error occurred';
                    $('#error_message').html(`<span class="text-danger">${errorMessage}</span>`);
                } else {
                    alert('An unexpected error occurred.');
                }
                console.log(xhr.responseText);  
            }
        });
    });
   
  
    $(document).on('click', '.delete-category', function (e) {
            e.preventDefault();

            var categoryId = $(this).data('id');
            var rowToDelete = $(this).closest('tr');

            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: `/categories/delete/${categoryId}`, 
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        $('#success_alert').html(`<div class="alert alert-success">${response.success}</div>`);
                        rowToDelete.remove();  
                    },
                    error: function (xhr) {
                        alert('Failed to delete the category.');
                        console.log(xhr.responseText);
                    }
                });
            }
        });
   
   
    $(document).on('click', '.edit-category', function () {
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');
        
    
        $('#updateCategoryId').val(categoryId);
        $('#updateCategoryName').val(categoryName);

        // Show the modal
        $('#updateCategoryModal').modal('show');
    });

    
    $('#updateCategory').on('click', function (e) {
        e.preventDefault();
        $('#update_error_message').html(''); 

        var categoryId = $('#updateCategoryId').val();
        var categoryName = $('#updateCategoryName').val();

        $.ajax({
            url: `/categories/update/${categoryId}`,  
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}", 
                category_name: categoryName
            },
            success: function (response) {
                $('#updateCategoryModal').modal('hide'); 
                $('#update_success_alert').html(`<div class="alert alert-success">${response.success}</div>`); 

                
                $(`tr[data-id="${categoryId}"] td:nth-child(2)`).text(categoryName);
            },
            error: function (xhr) {
                if (xhr.status === 409 && xhr.responseJSON && xhr.responseJSON.error) {
                    $('#update_error_message').html(`<span class="text-danger">${xhr.responseJSON.error}</span>`);
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = errors.category_name ? errors.category_name[0] : 'An error occurred';
                    $('#update_error_message').html(`<span class="text-danger">${errorMessage}</span>`);
                } else {
                    alert('An unexpected error occurred.');
                }


                
                console.log(xhr.responseText);  
            }
        });
    });
});

</script>

   
    @endsection
