@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title text-primary"> Add Products </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <a href="{{url('/dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Products</li>
                    <li class="breadcrumb-item text-warning active" aria-current="page">Add Products</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 grid-margin mt-5">
            <div class="card">
                <div class="card-body">
                    <form class="form-sample" id="add_product" enctype="multipart/formdata">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label> Product Title </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="text" class="form-control text-primary" name="title"
                                            placeholder="Enter Product Title">
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
                                        <input type="number" class="form-control text-primary" name="price"
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
                                        <textarea type="text" class="form-control text-primary" name="description" id="" cols="10" rows="2" placeholder="Enter Product Description"></textarea>
                                        {{-- <input type="text" class="form-control text-primary" name="description"
                                            placeholder="Enter Product Description"> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> Discount Price </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-view-grid"></i></span>
                                        </div>
                                        <input type="number" class="form-control text-primary" name="dis_price"
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
                                            name="quantity" placeholder="Enter product quantity">
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
                                            <select class="form-control" id="catg" name="category">
                                                <option value="" class="text-dark" id="inputCategory" selected>Choose a Category</option>
                                                @foreach ($category_data as $cate_data)
                                                    <option class="text-primary" value="{{ $cate_data->category_name }}">
                                                        {{ $cate_data->category_name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label> Product Image </label>
                                <div class="form-group">
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" name="image[]"
                                        class="file-upload-default">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            placeholder="Upload Image">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                type="button"><i class="mdi mdi-file-image"></i></button>
                                        </span>
                                    </div><br>
                                    <img src="" id="preview_img" style="display: none;height: 40%;width:20%;"><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <div class="error-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success float-right"><i class="mdi mdi-send"></i> Submit </button>
                        <button type="reset" id="resetProduct" class="btn btn-danger float-right mr-2"><i class="mdi mdi-refresh"></i> Reset </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
