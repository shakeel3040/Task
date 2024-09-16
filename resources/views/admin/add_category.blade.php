@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>General Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">General Form</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="categoryForm">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="categryname">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Category Name">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Make sure jQuery is included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $("#categoryForm").on("submit", function (event) {
            // Prevent form submission
            event.preventDefault();

            // Get the value of the input field
            var name = $("#name").val().trim();

            // Simple validation check
            if (name === "") {
                alert("Please enter a category name.");
                $("#name").focus();  // Focus on the input field
                return false;  // Prevent form submission
            }

            // If validation passes, you can submit the form or perform an AJAX request
            alert("Form submitted successfully!");

            // Uncomment the line below to submit the form after validation
            // this.submit();
        });
    });
</script>
@endsection
