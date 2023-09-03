@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Category </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <a href="{{url('/dashboard')}}"> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item text-warning active" aria-current="page">Category</li>
                </ol>
            </nav>
        </div>
        <div class="row ">
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <form id="add_category" class="forms-sample">
                            <div class="form-group">
                                <input type="text" class="form-control text-primary mb-2" id="exampleInputUsername1"
                                    name="category" placeholder="Enter Category name">
                            </div>
                            <div class="float-right">
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="printbar"></div>
                            <table id="categoryTable" class="table">
                                <thead>
                                    <tr style="background: linear-gradient(to top left, #ff00ff 0%, #00c8ff 100%)">
                                        <th class="text-center text-white"> Serial No </th>
                                        <th class="text-center text-white"> Category Name </th>
                                        <th class="text-center text-white" data-orderable="false"> Action </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
