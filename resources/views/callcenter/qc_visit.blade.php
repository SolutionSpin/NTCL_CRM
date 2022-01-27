@extends('layouts.admin-layout')
@section('title', 'QC Visit')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">All Call</h3>
                </div>
                <div class="card-body pb-0 shadow-3">
                    <table class="table  data-table">
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
                        @if (count($garments) > 0)
                            @foreach ($garments as $key=> $garment)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$garment->name}}</td>
                            <td>{{$garment->dir_name}}</td>
                            <td>{{$garment->designation}}</td>
                            <td>{{$garment->phone}}</td>
                            <td><button class="btn btn-sm admin-submit-btn-grad text-white" onclick="load_garment({{$garment->id}})"><i class="fas fa-eye"></i></button></td>

                        </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if (count($garments) > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination justify-content-end">
                                        {!! $garments->links() !!}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header custom-header">
                <h6 class="modal-title  modal-heading" id="exampleModalLabel">Company Details</h6>
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
    <script type="text/javascript">
        $(function () {

            // $('.data-table').DataTable( {
            //     responsive: true,
            //     searching: true,
            //     "paging": false
            // } );

        });

        

        function load_garment(id){
            var token = "{{ csrf_token() }}";
            var url_data = "{{ url('qc/call-center/get-garment-data') }}";
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
                            '<div class="row custom_data">'+
                                '<div class="col-md-4">'+ 
                                    
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0" >Name:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].dir_name+'">'+
                                        '<input type="hidden" name="customer_id" id="customer_id" class="form-control" value="'+data[0].id+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Designation:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].designation+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Phone:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].phone+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Company Name:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].name+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Registration No. :</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].reg_no+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Company Address:</label>'+
                                        '<textarea type="text" class="form-control" readonly>'+data[0].company_address+'</textarea>'+
                                    '</div>'+
                                    
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Contact Pesson:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].contact_name+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Contact Person Phone:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].contact_number+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Factory Address:</label>'+
                                        '<textarea type="text" class="form-control" readonly>'+data[0].factory_address+'</textarea>'+
                                    '</div>'+
                                    // '<div class="form-group">'+
                                    //     '<label class="form-label">Contact Person Email:</label>'+
                                    //     '<input type="text" class="form-control" readonly value="'+data[0].email+'">'+
                                    // '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-12">'+
                                    '<b>Product Details</b><hr class="mb-0 mt-0">'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Principal Producty:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].principal_products+'">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Product Capacity:</label>'+
                                        '<input type="text" class="form-control" readonly value="'+data[0].prod_capacity+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            // '<div class="row">'+
                            //     '<div class="col-md-12">'+
                            //         '<hr class="mb-0">'+
                            //     '</div>'+
                            //     '<div class="col-md-6">'+ 
                            //         '<div class="form-group">'+
                            //             '<label class="form-label">Call Status <span class="text-red">*</span>:</label>'+
                            //             '<select type="text" name="call_status" id="call_status" class="form-control" required onChange="show_datetime(this.value)">'+
                            //                 '<option value="">Select One</option>'+    
                            //                 '<option value="Complete">Complete</option>'+
                            //                 '<option value="Busy">Busy</option>'+
                            //                 '<option value="Rescheduale">Rescheduale</option>'+
                            //                 '<option value="Wating">Wating</option>'+
                            //                 '<option value="Invalid Number">Invalid Number</option>'+
                            //                 '<option value="Not Received">Not Received</option>'+
                            //             '</select>'+
                            //         '</div>'+
                            //     '</div>'+
                            //     '<div class="col-md-6">'+
                            //         '<div class="form-group">'+
                            //             '<label class="form-label">Call Summary <span class="text-red">*</span>:</label>'+
                            //             '<textarea type="text" name="call_summary" id="call_summary" class="form-control" required></textarea>'+
                            //         '</div>'+
                            //     '</div>'+
                            // '</div>'+
                            // '<div class="row d-none" id="date_time">'+
                            //     '<div class="col-md-3">'+ 
                            //         '<div class="form-group">'+
                            //             '<label class="form-label">Rescheduale Date:</label>'+
                            //             '<input type="date" name="reschedule_date" id="reschedule_date" class="form-control" value="">'+
                            //         '</div>'+
                            //     '</div>'+
                            //     '<div class="col-md-3">'+
                            //         '<div class="form-group">'+
                            //             '<label class="form-label">Time:</label>'+
                            //             '<input type="time" name="reschedule_time" id="reschedule_time" class="form-control" value="">'+
                            //         '</div>'+
                            //     '</div>'+
                            // '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">QC Visit Required <span class="text-red">*</span>:</label>'+
                                        '<select readonly type="text" name="qc_visit" id="qc_visit" class="form-control" required onChange="visit_datetime(this.value)">'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Yes">Yes</option>'+
                                            '<option value="No">No</option>'+
                                        '</select>'+
                                    '</div>'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">QC Visit Status <span class="text-red">*</span>:</label>'+
                                        '<select type="text" name="qc_visit_status" id="qc_visit_status" class="form-control" required>'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Pending">Pending</option>'+
                                            '<option value="Done">Done</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3 d-none" id="vis_date">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Appointment Date:</label>'+
                                        '<input type="date" name="visit_date" id="visit_date" class="form-control" readonly value="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3 d-none" id="vis_time">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Time:</label>'+
                                        '<input type="time" name="visit_time" id="visit_time" class="form-control" readonly value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    const res_date_time = data[0].rescheduale_time;
                    
                    const res_arr = res_date_time.split(" ");

                    var res_date = res_arr[0];
                    var res_time = res_arr[1];

                    const vis_date_time = data[0].visit_date;
                    
                    const vis_arr = vis_date_time.split(" ");

                    var vis_date = vis_arr[0];
                    var vis_time = vis_arr[1];

                    // $("#call_status").val(data[0].call_status);
                    // $("#call_summary").val(data[0].call_summary);
                    // $("#reschedule_date").val(res_date);
                    // $("#reschedule_time").val(res_time);
                    $("#qc_visit").val(data[0].qc_visit);
                    $("#visit_date").val(vis_date);
                    $("#visit_time").val(vis_time);
                    $("#qc_visit_status").val(data[0].qc_visit_status);
                    
                    //show_datetime();
                    visit_datetime();
                }
            });
            $('#exampleModal').modal('show');
        }



        function visit_datetime(value){
            if (value === 'No') {
                $("#vis_date").addClass('d-none');
                $("#vis_time").addClass('d-none');
            } else {
                $("#vis_date").removeClass('d-none');
                $("#vis_time").removeClass('d-none');
            }
            
        }

        function save_call_details(){
            var qc_visit_status = $("#qc_visit_status").val();
            var customer_id = $("#customer_id").val();
            

            if ( (qc_visit_status == '' || qc_visit_status == null)  ) {
                if (qc_visit_status == '' || qc_visit_status == null) {
                    alert("Call status is required");
                    $("#qc_visit_status").focus();
                    return false;
                }
                
            } else {
                var csrf_token = "{{ csrf_token() }}";
                var url = "{{ url('qc/call-center/store-qc-visit-data') }}";
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        _token: csrf_token,
                        qc_visit_status: qc_visit_status,
                        customer_id:customer_id
                    },
                    success: function(data) {
                        if (data == 'success') {
                            alert("data successfully saved");
                            $("#modal-body").empty();
                            $('#exampleModal').modal('toggle');
                            location.reload();
                        } else {
                            alert("500");
                        }
                    }
                });

                
            }


        }
    </script>
@endsection

