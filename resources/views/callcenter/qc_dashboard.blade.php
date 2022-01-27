
@extends('layouts.admin-layout')
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
    
@endsection
