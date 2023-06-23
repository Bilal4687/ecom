@extends('AdminLayout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h3 mb-0 font-weight-bold text-gray-800">Product Detail</div>
                            </div>
                            <div class="col-auto">

                                <a href="{{ route('AddProduct') }}" type="button" class="btn btn-primary">Add</a>

                                {{-- Cropper Modal --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive" style="padding: 10px;">
        <table id="DataTable" class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
$(document).ready(function () {


    DataTable = $("#DataTable").DataTable({
        responsive: true,
        dom: '<"top"<"left-col"B><"right-col"f>>r<"table table-striped"t>ip',
        order: [
            [0, 'desc']
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength'],
        ajax: {
            url:" {{ route('ProductShow') }}",
            dataSrc: '',
        },
        columns: [
            {data : 'product_id'},
            {data : 'product_main_image', render: (data)=>{
                return `<img src="{{url('public/Product')}}/${data}">`
            }},
            {data : 'product_name'},
            {data : 'product_description'},
            {data : 'product_id', render: (data)=>{
                return `<a href="{{route('AddProduct')}}?id=${data}">Edit</a>`;
            }}
    ]
    });
});
    </script>
@endsection
