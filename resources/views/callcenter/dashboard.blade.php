
@extends('layouts.agent-layout')
@section('title', 'Callcenter')
@section('content')
    
    <div class="content p-3">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Total Company')}}</span>
                        <span
                            class="info-box-number"> {{App\Garment::count('id')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Complete Call')}}</span>
                        <span
                            class="info-box-number"> {{App\Garment::where('call_status','Complete')->count('id')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-wallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Pending Call')}}</span>
                        <span
                            class="info-box-number">{{App\Garment::where('call_status','!=','Complete')->count('id')}}</span>
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

    

@endsection
