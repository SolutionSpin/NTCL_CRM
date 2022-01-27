
@extends('layouts.admin-layout')
@section('title', 'Callcenter')
@section('content')
    <link rel="stylesheet" href="{{asset('assets/callcenter/datatablecustom.css')}}">
    
    <div class="content p-3">
        <div class="container-fluid">

            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="card card-outline card-new-color1">
                        <div class="card-header">
                            <h3 class="card-title">All Call</h3>
                            <!-- <a href="{{ url('customer/orders/create') }}" class="btn btn-primary float-right"><i
                                    class="fa fa-plus"></i> &nbsp; add</a> -->
                        </div>
                        <div class="card-body">
                            
                                <div class="table-responsive table-lg">
                                    <table class="table" id="dataList">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Garment Name</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Phone</th>
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
    <!-- Modal -->
    <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Company Detaiels</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onClick="save_call_details()">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/callcenter/complete_visit.js')}}"></script>
    
    <script type="text/javascript">
        $(function () {

            // $('.data-table').DataTable( {
            //     responsive: true,
            //     searching: true
            // } );

        });

        function load_garment(id){
            var token = "{{ csrf_token() }}";
            var url_data = "{{ url('agent/call-center/get-garment-data') }}";
            $.ajax({
                method: "GET",
                url: url_data,
                dataType: "json",
                data: {
                    _token: token,
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $("#modal-body").empty();
                    $("#modal-body").append(
                        '<div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+ 
                                    
                                    '<div class="form-group">'+
                                        '<label class="form-label">Name:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].dir_name+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Designation:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].designation+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Phone:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="0'+data[0].phone+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Contact Pesson:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].contact_name+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Contact Person Phone:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="0'+data[0].contact_number+'">'+
                                    '</div>'+
                                    // '<div class="form-group">'+
                                    //     '<label class="form-label">Contact Person Email:</label>'+
                                    //     '<input type="text" class="form-control mb-4" readonly value="'+data[0].email+'">'+
                                    // '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Company Name:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].name+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Registration No. :</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].reg_no+'">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Company Address:</label>'+
                                        '<textarea type="text" class="form-control mb-4" readonly>'+data[0].company_address+'</textarea>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Factory Address:</label>'+
                                        '<textarea type="text" class="form-control mb-4" readonly>'+data[0].factory_address+'</textarea>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-12">'+
                                    '<h4>Product Details</h4><hr>'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Principal Producty:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].principal_products+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Product Capacity:</label>'+
                                        '<input type="text" class="form-control mb-4" readonly value="'+data[0].prod_capacity+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-12">'+
                                    '<h4>Product Details</h4><hr>'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Call Status <span class="text-red">*</span>:</label>'+
                                        '<select type="text" name="call_status" id="call_status" class="form-control mb-4" required onChange="show_datetime(this.value)">'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Complete">Complete</option>'+
                                            '<option value="Busy">Busy</option>'+
                                            '<option value="Rescheduale">Rescheduale</option>'+
                                            '<option value="Wating">Wating</option>'+
                                            '<option value="Invalid Number">Invalid Number</option>'+
                                            '<option value="Not Received">Not Received</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Call Summary <span class="text-red">*</span>:</label>'+
                                        '<textarea type="text" name="call_summary" id="call_summary" class="form-control mb-4" required></textarea>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row d-none" id="date_time">'+
                                '<div class="col-md-3">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Rescheduale Date:</label>'+
                                        '<input type="date" name="reschedule_date" id="reschedule_date" class="form-control mb-4" value="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                        '<label class="form-label">Time:</label>'+
                                        '<input type="time" name="reschedule_time" id="reschedule_time" class="form-control mb-4" value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    
                }
            });
            $('#exampleModal').modal('show');
        }


        function show_datetime(value){
            if (value === 'Complete' || value === 'Invalid Number') {
                $("#date_time").addClass('d-none');
            } else {
                $("#date_time").removeClass('d-none');
            }
            
        }

        function save_call_details(){
            var call_status = $("#call_status").val();
            var call_summary = $("#call_summary").val();
            var reschedule_date = $("#reschedule_date").val();
            var reschedule_time = $("#reschedule_time").val();
            

            if ( (call_status == '' || call_status == null) || (call_summary == '' || call_summary == null) ) {
                if (call_status == '' || call_status == null) {
                    alert("Call status is required");
                    $("#call_status").focus();
                    return false;
                }
                if (call_summary == '' || call_summary == null) {
                    alert("Call Summary is required");
                    $("#call_summary").focus();
                    return false;
                }
            } else {
                
            }


        }
    </script>
@endsection
