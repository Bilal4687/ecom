@extends('AdminLayout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card  mt-2">
                    <div class="card-header">
                        <h4>Add Product Detail</h4>
                    </div>
                    <div class="card-body">
                        <form id="ProductStoreForm">
                            @csrf
                            <input type="hidden" id="product_id" name="product_id">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" value="{{$data->product_name??""}}" id="product_name" name="product_name" placeholder="Product name">
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Product Description</label>
                                    <input type="text" class="form-control" value="{{$data->product_description??""}}" id="product_description" name="product_description" placeholder="Product name">
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Product Main Image</label>
                                    <input type="file" class="form-control" value="" id="product_main_image" name="product_main_image" placeholder="Product name">
                                </div>
                                                        </div>
                        </form>

<form id="attibuteForm">
@csrf
    <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Attributes</label>
                                        <select class="form-control select2" name="attribute_name" id="attribute_name" style="width:100%;" >
                                            <option selected disabled>Select Attributes</option>
                                            @foreach ($defaultAttributes as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Attribute Value
                                            </label>
                                        <input type="text"
                                            class="form-control form-control-user required "
                                            id="attribute_value" name="attribute_value">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Price
                                            </label>
                                        <input type="number"
                                            class="form-control form-control-user required "
                                            id="attribute_price" name="attribute_price">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Image
                                            </label>
                                        <input type="file"
                                            class="form-control form-control-user required "
                                            id="attribute_image" name="attribute_image">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="custom-control custom-switch">
                                        <div class="form-group">
                                            <label class="text-bold">Status</label>
                                            <input type="checkbox" id="status" name="status">
                                        </div>
                                </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label style="display: none">Add</label>
                                        <br>
                                        <button type="button" id="AttributesaStoreBtn"
                                        onclick="AddAttributes()" class="btn btn-success ml-1"><i
                                            class="fas fa-plus "></i></button>
                                    </div>
                                </div>
                </div>
</form>


                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Attribute</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="Student_Subject">
                                            @foreach ($attributes   as $row)
                                            <tr>
                                                <td>{{$row->attribute_name}}</td>
                                                <td>{{$row->attribute_value}}</td>
                                                <td>{{$row->attribute_price}}</td>
                                                <td><img style="height: 50px; width: auto;" src="{{url('public/AttributeImage')}}/{{$row->attribute_image}}"></td>
                                                <td><button type="button" id="BtnMinus" class="btn btn-danger ml-1"><i class="fas fa-minus "></i></button></td> </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="button" id="btnSubmit" onclick="ProductStore()" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

var attributes = [];
function AddAttributes() {


    let Attribute = document.getElementById("attibuteForm");
                let form_data = new FormData(Attribute);

                $("#btnSubmit").prop("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "{{ route('AttributeStore') }}",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: (res) => {
                        if (res.validate) {
                            alert(res.message, "warning")
                        }
                        $("#btnSubmit").prop("disabled", false);
                        $('#Student_Subject').append(
        `<tr>
            <td>${res.data.attribute_name}</td>
            <td>${res.data.attribute_value}</td>
            <td>${res.data.attribute_price}</td>
            <td><img style="height: 50px; width: auto;" src="{{url('public/AttributeImage')}}/${res.data.attribute_image}"></td>
            <td><button type="button" id="BtnMinus" class="btn btn-danger ml-1"><i class="fas fa-minus "></i></button></td> </tr>`
        )

        attributes.push(res.id)
        console.log(attributes);
                    },
                    error: (err) => {
                        alert("Something went wrong", "danger");
                        $("#btnSubmit").prop("disabled", false);
                    }

                });
                alert('Atribute added successfully')
    // marksArray.push(Attributes)


}

        function ProductStore()
        {
            let product_form_data = document.getElementById("ProductStoreForm");
                let form_data = new FormData(product_form_data);

                $("#btnSubmit").prop("disabled", true);
            form_data.append("attributes_id", JSON.stringify(attributes));
                $.ajax({
                    type: "POST",
                    url: "{{ route('ProductStore') }}",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: (res) => {
                        $("#btnSubmit").prop("disabled", false);
                        if (res.success) {
                            alert(res.message);

                        } else if (res.validate) {
                            alert(res.message)
                        } else {
                            alert(res.message)
                        }
                    },
                    error: (err) => {
                        alert("Something went wrong", "danger");
                        $("#btnSubmit").prop("disabled", false);
                    }

                });
        }
    </script>
    @endsection
