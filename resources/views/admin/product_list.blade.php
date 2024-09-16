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
              <li class="breadcrumb-item active">Product List</li>
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
              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right">Add Product</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Product Name</th>
                    <th>Category Name</th> 
                    <th>Action</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  @php 
                        $counter=1;
                    @endphp
                  @foreach ($data as $product)
                 
           
                  <tr data-id="{{ $product->id }}">
                    <td>{{$counter;  }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                       
                        @if($product->categories->isNotEmpty())
                            @foreach($product->categories as $category)
                                <span class="badge badge-info">{{ $category->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No Categories</span>
                        @endif
                    </td>
                    <td>
                    <a href="javascript:void(0);" class="edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="delete-product" data-id="{{ $product->id }}">
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="success_alert"></span>
        <form id="addProductForm" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" placeholder="Enter product name">
            <span id="error_message" class="text-danger"></span>
          </div>

          <div class="form-group">
            <label for="productCategories">Categories</label>
            <select class="form-control select2" id="categories" name="category_id[]" multiple="multiple" style="width: 100%;">
                @foreach($list_category as $list)
                <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="productImages">Product Images</label>
            <input type="file" class="form-control" id="productImages" name="image_path[]" multiple>
            <span id="image_error_message" class="text-danger"></span>
          </div>
          
         
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveProduct">Save Product</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Category Modal -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
   
    $('.select2').select2();

    $('#saveProduct').click(function (e) {
        e.preventDefault();

       
        $('#error_message').html('');
        $('#image_error_message').html('');

        var formData = new FormData($('#addProductForm')[0]);

     
        $.ajax({
            url: "{{ route('products.store') }}", 
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
              if (response.success) {
                  $('#exampleModal').modal('hide');  
                  $('#productName').val(''); 
                  $('#success_alert').html(`<div class="alert alert-success">${response.message}</div>`); 

                  var newRow = `
                      <tr data-id="${response.product.id}">
                          <td>${$('#example1 tbody tr').length + 1}</td>
                          <td>${response.product.name}</td>
                          <td>
                              <a href="javascript:void(0);" class="edit-category" data-id="${response.product.id}" data-name="${response.product.name}"><i class="fa fa-edit"></i></a>
                              <a href="javascript:void(0);" class="delete-category" data-id="${response.product.id}"><i class="fa fa-trash"></i></a>
                          </td>
                      </tr>
                  `;
                  $('#example1 tbody').append(newRow); 
              }
          },
            error: function (xhr) {
               
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.product_name) {
                        $('#error_message').html(errors.product_name[0]);
                    }
                    if (errors.image_path) {
                        $('#image_error_message').html(errors.image_path[0]);
                    }
                } else {
                    console.error(xhr); 
                }
            }
        });
    });
});

$(document).on('click', '.delete-product', function() {
        var productId = $(this).data('id');
        var row = $(this).closest('tr'); 

        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '/products/' + productId,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}" 
                },
                success: function(response) {
                    row.remove(); 
                    alert('Product deleted successfully.');
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the product.');
                    console.error(xhr); 
                }
            });
        }
    });

</script>


   
    @endsection
