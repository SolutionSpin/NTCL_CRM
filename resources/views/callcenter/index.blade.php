@extends('layouts.admin-layout')
@section('title', 'All Call')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">List of Garment</h3>
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
                <!-- <button type="button" class="btn btn-primary" onClick="save_call_details()">Save changes</button> -->
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
                                    '<div class="form-group">'+
                                        '<label class="form-label">Contact Person Email:</label>'+
                                        '<input type="text" name="email" id="email" class="form-control" value="'+data[0].email+'">'+
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
                                        '<input type="text" class="form-control" readonly value="0'+data[0].contact_number+'">'+
                                    '</div>'+
                                    '<div class="form-group mb-0">'+
                                        '<label class="form-label mb-0">Factory Address:</label>'+
                                        '<textarea type="text" class="form-control" readonly>'+data[0].factory_address+'</textarea>'+
                                    '</div>'+
                                    
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
                            '<div class="row">'+
                                '<div class="col-md-12">'+
                                    '<b>Call Details</b><hr class="mb-0 mt-0">'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">TC Codes <span class="text-red">*</span>:</label>'+
                                        '<select type="text" name="tc_code" id="tc_code" class="form-control" required onChange="load_status()">'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Non Connected call">Non Connected call</option>'+
                                            '<option value="Connected call">Connected call</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Call Summary <span class="text-red">*</span>:</label>'+
                                        '<textarea type="text" name="call_summary" id="call_summary" class="form-control" required></textarea>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            
                            '<div class="row ">'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Call Status <span class="text-red">*</span>:</label>'+
                                        '<select type="text" name="call_status" id="call_status" class="form-control" required onChange="show_datetime(this.value)">'+
                                            '<option value="">Select One</option>'+    
                                        '</select>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="col-md-3 d-none" id="rescheduale_date">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Call back date:</label>'+
                                        '<input type="date" name="reschedule_date" id="reschedule_date" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3 d-none" id="rescheduale_time">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Time:</label>'+
                                        '<input type="time" name="reschedule_time" id="reschedule_time" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row ">'+
                                '<div class="col-md-12">'+
                                    '<b>Call To Action</b><hr class="mb-0 mt-0">'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Google form query:</label>'+
                                        '<select type="text" name="google_form_query" id="google_form_query" class="form-control" required onChange="visit_datetime(this.value)">'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Only email">Only email</option>'+
                                            '<option value="WhatsApp and Email">WhatsApp and Email</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">WhataApp Number:</label>'+
                                        '<input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">QC visit required ?</label>'+
                                        '<select type="text" name="qc_visit" id="qc_visit" class="form-control" required onChange="visit_datetime(this.value)">'+
                                            '<option value="">Select One</option>'+    
                                            '<option value="Yes">Yes</option>'+
                                            '<option value="No">No</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3 d-none" id="vis_date">'+ 
                                    '<div class="form-group">'+
                                        '<label class="form-label">Visit Date:</label>'+
                                        '<input type="date" name="visit_date" id="visit_date" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3 d-none" id="vis_time">'+
                                    '<div class="form-group">'+
                                        '<label class="form-label">Time:</label>'+
                                        '<input type="time" name="visit_time" id="visit_time" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    const res_date_time = data[0].rescheduale_time;

                    const vis_date_time = data[0].visit_date;
                    $("#tc_code").val(data[0].tc_code);
                    load_status();
                    
                    $("#google_form_query").val(data[0].google_form_query);
                    $("#whatsapp_no").val(data[0].whatsapp_no);
                    $("#call_summary").val(data[0].call_summary);
                    if (res_date_time) {
                        const res_arr = res_date_time.split(" ");

                        var res_date = res_arr[0];
                        var res_time = res_arr[1];
                        $("#reschedule_date").val(res_date);
                        $("#reschedule_time").val(res_time);
                    }
                    $("#call_status").val(data[0].call_status);
                   
                    $("#qc_visit").val(data[0].qc_visit);
                    if (vis_date_time) {
                        const vis_arr = vis_date_time.split(" ");

                        var vis_date = vis_arr[0];
                        var vis_time = vis_arr[1];

                        $("#visit_date").val(vis_date);
                        $("#visit_time").val(vis_time);
                    }
                    
                    
                    show_datetime();
                    visit_datetime();
                }
            });
            $('#exampleModal').modal('show');
        }


        function show_datetime(){
            value = $("#call_status").val();
            
            if (value === 'Call Back') {
                $("#rescheduale_date").removeClass('d-none');
                $("#rescheduale_time").removeClass('d-none');
                
            } else {
                $("#rescheduale_date").addClass('d-none');
                $("#rescheduale_time").addClass('d-none');
            }
            
        }

        function visit_datetime(){

            visit_value = $("#qc_visit").val();

            if (visit_value == 'Yes') {
                $("#vis_date").removeClass('d-none');
                $("#vis_time").removeClass('d-none');
                
            } else {
                $("#vis_date").addClass('d-none');
                $("#vis_time").addClass('d-none');
            }
            
        }

        function save_call_details(){
            var call_status = $("#call_status").val();
            var call_summary = $("#call_summary").val();
            var reschedule_date = $("#reschedule_date").val();
            var reschedule_time = $("#reschedule_time").val();
            var qc_visit = $("#qc_visit").val();
            var visit_date = $("#visit_date").val();
            var visit_time = $("#visit_time").val();
            var customer_id = $("#customer_id").val();
            

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
                
            } else if ((call_status == 'Busy' || call_status == 'Rescheduale' || call_status =='Wating' || call_status == 'Not Received') && (reschedule_date == '' || reschedule_date == null || reschedule_time == '' || reschedule_time == null)) {
                if (reschedule_date == '' || reschedule_date == null) {
                    alert("Reschedule date is required");
                    $("#reschedule_date").focus();
                    return false;
                }
                if (reschedule_time == '' || reschedule_time == null) {
                    alert("Time is required");
                    $("#reschedule_time").focus();
                    return false;
                }
                console.log('test')
            } else {
                var csrf_token = "{{ csrf_token() }}";
                var url = "{{ url('agent/call-center/store-call-data') }}";
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        _token: csrf_token,
                        call_status: call_status,
                        call_summary:call_summary,
                        reschedule_date:reschedule_date,
                        reschedule_time:reschedule_time,
                        qc_visit:qc_visit,
                        visit_date:visit_date,
                        visit_time:visit_time,
                        customer_id:customer_id

                    },
                    success: function(data) {
                        if (data == 'success') {
                            alert("data successfully saved");
                            $("#modal-body").empty();
                            $('#exampleModal').modal('toggle');
                        } else {
                            alert("500");
                        }
                    }
                });

                
            }


        }

        function load_status(){
            var tcCode = $("#tc_code").val();
            if (tcCode == "Non Connected call") {
                $("#call_status").empty();
                $("#call_status").append(
                    '<option value="">Select One</option>'+    
                    '<option value="Swiched Off">Swiched Off</option>'+
                    '<option value="Number Invalid / Does not exist">Number Invalid / Does not exist</option>'+
                    '<option value="Ringing No Response">Ringing No Response</option>'
                );
            } else if(tcCode == "Connected call") {
                $("#call_status").empty();
                $("#call_status").append(
                    '<option value="">Select One</option>'+    
                    '<option value="Call Back">Call Back</option>'+
                    '<option value="Not Interested">Not Interested</option>'+
                    '<option value="Interested">Interested</option>'
                );
            } else {
                $("#call_status").empty();
                $("#call_status").append(
                    '<option value="">Select One</option>'
                );
            }
            
        }
    </script>
@endsection

