@extends('admin.layouts.app')
@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/js/bootstrap.min.js"></script> --}}
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: -7px;
        left: 0;
        right: 0;
        bottom: 5px;
        background-color: orange;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 5px;
    }

    .slider.round:before {
        border-radius: 60%;
    }

    .all_btn {
        text-align: center;
    }

    .label0 {
        margin-bottom: 0rem;
    }
    table.dataTable thead>tr>th.sorting::before,
    table.dataTable thead>tr>th.sorting::after {
        width: 0;
        height: 0;
        display: flex;
        align-items: center;
    }
</style>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Products </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <a href="{{url('/dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Products</li>
                    <li class="breadcrumb-item text-warning active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
        <div class="row bg-dark">
            <div class="col-12 grid-margin">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="printbar"></div>
                            <table id="productTable" class="table">
                                <thead>
                                    <tr style="background: linear-gradient(to top left, #ff00ff 0%, #00ffcc 100%)">
                                        <th class="text-center text-white"> Serial No </th>
                                        <th class="text-center text-white"> Product Title </th>
                                        <th class="text-center text-white"> Description </th>
                                        <th class="text-center text-white"> Quantity </th>
                                        <th class="text-center text-white"> Category </th>
                                        <th class="text-center text-white"> Price </th>
                                        <th class="text-center text-white"> Discount Price </th>
                                        <th class="text-center text-white" data-orderable="false"> Product Image </th>
                                        <th class="text-center text-white" data-orderable="false"> Action </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center text-white">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="offcanvas offcanvas-end text-bg-dark" style="width: 40%;" id="sidebardemo">
            <div class="offcanvas-header mt-3">
                <span class="badge badge-lg badge-outline-success text-white">Edit Product Details</span>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    <div class="card col-md-11 mx-auto" style="padding: 30px;border: 2px solid gray;">
                        <form id="update_products" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="prod_id" />
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="editTitle">Product Title</label>
                                    <input type="text" name="update_title" class="form-control text-primary"
                                        id="editTitle" placeholder="Write a title">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="editDescription">Product Desctiption</label>
                                    <input type="text" name="update_description" class="form-control text-primary"
                                        id="editDescription" placeholder="Write a description">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="editPrice">Product Price</label>
                                    <input type="number" name="update_price" class="form-control text-primary"
                                        id="editPrice" placeholder="Enter product price">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="editDiscount">Discount Price</label>
                                    <input type="number" name="update_dis_price" class="form-control text-primary"
                                        id="editDiscount" placeholder="Enter discount price if applicable">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="editQuantity">Product Quantity</label>
                                    <input type="number" min="0" class="form-control text-primary"
                                        name="update_quantity" id="editQuantity" placeholder="Enter product quantity">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cats">Product category</label>
                                    <select id="cats" class="form-control bg-white" name="update_category">
                                        <option class="text-primary" id="editCategory" value="">
                                        </option>
                                    </select>
                                </div>
                                <input type="hidden" class="form-control" name="old_pic" id="old_image">
                                <div class="form-group col-md-4">
                                    <label for="editImage">Product Image</label>
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" class="form-control"
                                        name="update_image" onchange="previewFile();" style="border: 2px solid white;"
                                        id="editImage"><br>
                                    <img src="" id="update_pic" style="height: 40% width:50%;"><br>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary update_prod float-right">Update
                                Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-12 grid-margin mt-5">
            <div class="card">
                <div class="card-body">
                    <form class="form-sample" id="update_products" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label> Product Title </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="text" class="form-control text-primary" name="update_title"
                                            id="editTitle" placeholder="Enter Product Title"><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> Product price </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="number" class="form-control text-primary" name="update_price" id="editPrice"
                                            placeholder="Enter Product Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label> Product Description </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="text" class="form-control text-primary" name="update_description" id="editDescription"
                                            placeholder="Enter Product Description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> Product Discount Price </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="number" class="form-control text-primary" name="update_dis_price" id="editDiscount"
                                            placeholder="Enter Discount Price if Applicable">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-3">
                                <label> Product Quantity </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="number" min="1" class="form-control text-primary"
                                            name="update_quantity" id="editQuantity" placeholder="Enter product quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-3">
                                <label> Product Category </label>
                                <div class="form-group">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                            </div>
                                            <select class="form-control" id="cats" name="update_category">
                                                <option value="1" class="text-dark" id="editCategory" value="">Choose a Category</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <input type="hidden" class="form-control" name="old_pic" id="old_image">
                                <div class="form-group col-md-4">
                                    <label for="editImage">Product Image</label>
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" class="form-control"
                                        name="update_image" onchange="previewFile();" style="border: 2px solid white;"
                                        id="editImage"><br>
                                    <img src="" id="update_pic" style="height: 40% width:50%;"><br>
                                </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="hidden" class="form-control" name="old_pic" id="old_image">
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" name="update_image[]"
                                        class="file-upload-default" id="editImage" onchange="previewFile();">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            placeholder="Upload Image">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                type="button"><i class="mdi mdi-file-image"></i></button>
                                        </span>
                                    </div><br>
                                    <img src="" id="update_pic" style="height: 40%;width:50%;"><br>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right"><i class="mdi mdi-send"></i> Update </button>
                        <button type="reset" id="cancelUpdate" class="btn btn-danger float-right mr-2"><i class="mdi mdi-window-close"></i> Cancel </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
