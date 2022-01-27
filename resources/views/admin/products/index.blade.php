@extends('layouts.admin-layout')
@section('title', 'Items')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">{{ __('all.items') }}</h3>
                                    <button type="button" class="btn btn-xs admin-submit-btn-grad float-right" data-toggle="modal"
                                            data-target="#productModal"><i class="fa fa-plus"></i>Add New Product</button>
                                </div>
                                <div class="card-body">
                                        <table class="data-table" id="dataList">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>IsSubscription</th>
                                                <th>Validity (Days)</th>
                                                <th>isActive</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="productModal" class="modal animated zoomInUp custo-zoomInUp  mt-5" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('all.add_items') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <form id="ProductForm">
                            {{ @csrf_field() }}
                            <div class="form">

                                <div class="form-group ">
                                    <label for="profession">Product name</label>
                                    <input type="text" class="form-control mb-4" name="name" id="name">
                                </div>
                                        <div class="form-group">
                                            <label for="fullName">{{ __('all.description') }}</label>
                                            <textarea type="text" class="form-control mb-4" name="description"
                                                id="description"></textarea>
                                        </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control mb-4" name="price" id="price">
                                </div>
                                <div class="form-group">
                                    <label for="price">Subscription Based?</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input ml-2" name="isSubscription" id="isSubscriptionYes" value="1"><label for="isSubscriptionYes" class="form-check-label">Yes</label>
                                        <input type="radio" class="form-check-input ml-2" name="isSubscription" id="isSubscriptionNo" value="0"><label for="isSubscriptionNo" class="form-check-label">No</label>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="price">Validity (If available)</label>
                                    <select class="form-control" name="validity" id="validity">
                                        <option value="0">One Time</option>
                                        <option value="7">One week</option>
                                        <option value="30">One Month</option>
                                        <option value="90">3 Months</option>
                                        <option value="180">6 Months</option>
                                        <option value="360">One Year</option>
                                    </select>
                                </div>
                                    </div>
                                <div class="mt-3">
                                <button class="btn admin-submit-btn-grad btn-sm add-item">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            /* item add */
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", ".add-item", function(event) {
                'use strick';
                event.preventDefault();
                if ($('#name').val() == '') {
                    alert("please enter name");
                    return false;
                }


                var postData = new FormData($("#ProductForm")[0]);

                $.ajax({
                    url: "{{ url('admin/items/product/'.request()->route('id')) }}",
                    data: postData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: "POST",

                    success: function(data) {
                        if (data == "error") {
                            swal("Failure!", "Name already Taken.", "error");
                        } else {
                            $('#MyItemForm').trigger("reset");
                            $('#ItemModel').modal('hide')
                            swal({
                                    title: "Success!",
                                    text: "Items added Successfully.!",
                                    icon: "success",
                                })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        window.location.reload();
                                    }
                                });
                        }
                    }
                })
            })
        });
    </script>
    <script>
        function editProduct(id){
            $.ajax({
                type:"GET",
                url: "{{ url('admin/items/product/get') }}" + "/"+ id,
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#productModal').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.id);
                    $('#description').val(res.description);
                    $('#price').val(res.price);
                    if(res.isSubscription==1){
                        $('#isSubscriptionYes').prop("checked", true);
                    }
                    else {
                        $('#isSubscriptionNo').prop("checked", true);
                    }
                    $('#validity').val(res.validity).trigger();

                }
            });
        }
        // update data
        $('#dataForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{ url('admin/items/product/update') }}" + "/"+ id,
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.created == 1){
                        toastr.success("Location Created Successfully");
                    }
                    else {
                        toastr.success("Location Updated Successfully");
                    }
                    $("#dataModal").modal('hide');
                    var oTable = $('#dataList').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                },
                error: function(data){
                    toastr.error("Operation Failed");
                }
            });
        });
    </script>
    <script>
        /* update payment mode*/
        $(document).on("click", ".update-item", function(event) {
            'use strict';
            event.preventDefault();
            var id = $('#item_id').val();
            if ($('#edit_name').val() == '') {
                alert("please enter name");
                return false;
            }

            var postData = new FormData($("#MyItemEditForm")[0]);
            $.ajax({
                url: "{{ url('admin/items/update') }}" + '/' + id,
                data: postData,
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",

                success: function(data) {
                    if (data == "error") {
                        swal("Failure!", "Name already Taken.", "error");
                    } else {
                        $('#MyItemEditForm').trigger("reset");
                        $('#ItemEditModel').modal('hide')
                        swal({
                                title: "Success!",
                                text: "Item Updated Successfully.!",
                                icon: "success",
                            })
                            .then((isConfirm) => {
                                if (isConfirm) {
                                    window.location.reload();
                                }
                            });
                    }
                }
            });
        });



        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // fetch data
            $('#dataList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/items/view/'.request()->route('id')) }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'item_name', name: 'item_name'},
                    { data: 'price', name: 'price'},
                    { data: 'isSubscription', name: 'isSubscription'},
                    { data: 'validity', name: 'validity'},
                    { data: 'isActive', name: 'isActive'},
                    { data: 'action', name: 'action' },
                ],
                order: [[0, 'asc']],
                responsive: true,
                sorting: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'lfBrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Item Category List',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Item Category List',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Item Category List',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Item Category List',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'copy',
                        title: 'Item Category List',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ]
            });
        });


    </script>
@endpush
