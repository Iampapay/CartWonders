@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Orders </h3>
            {{-- <span class="badge badge-outline-success text-white mb-4">Order Table</span> --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <a href="{{url('/dashboard')}}"> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item text-warning active" aria-current="page">Orders</li>
                </ol>
            </nav>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="printbar"></div>
                            <table id="orderTable" class="table">
                                <thead>
                                    <tr style="background: linear-gradient(to top, #009933 0%, #0000ff 100%)">
                                        <th class="text-center text-white"> Serial No </th>
                                        <th class="text-center text-white"> User Name </th>
                                        <th class="text-center text-white"> Product Title </th>
                                        <th class="text-center text-white"> Product Quantity </th>
                                        <th class="text-center text-white"> Product Price </th>
                                        <th class="text-center text-white"> Billing Name </th>
                                        <th class="text-center text-white"> Phone No </th>
                                        <th class="text-center text-white"> Email Id </th>
                                        <th class="text-center text-white"> Country </th>
                                        <th class="text-center text-white"> State </th>
                                        <th class="text-center text-white"> City </th>
                                        <th class="text-center text-white"> Address 1 </th>
                                        <th class="text-center text-white"> Address 2 </th>
                                        <th class="text-center text-white"> Pin Code </th>
                                        <th class="text-center text-white"> Payment Mode </th>
                                        <th class="text-center text-white"> Payment Id </th>
                                        <th class="text-center text-white"> Order Status </th>
                                        <th class="text-center text-white"> Tracking No </th>
                                        <th class="text-center text-white"> Order Date </th>
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
