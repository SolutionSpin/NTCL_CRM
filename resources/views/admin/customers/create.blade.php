@extends('layouts.admin-layout')
@section('title', 'Create Customers')
@section('content')
    <div class="content p-3">
        <div class="container-fluid">
            <form
                action="{{ isset($customer) ? url('admin/customers/update/' . $customer->id) : url('admin/customers/create') }}"
                method="post" id="MyCustomerForm" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card card-outline shadow-3">
                            <div class="card-header admin-cart-header">
                                <h3 class="card-title">{{ __('all.basic_info') }}</h3>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.upload_photo') }}:</label>
                                            <input type="file" class="dropify"
                                                data-default-file="{{ !empty($customer->avatar) && File::exists('uploads/customer/' . $customer->avatar) ? asset('uploads/customer/' . $customer->avatar) : asset('uploads/customer/default.png') }}"
                                                data-max-file-size="2M" name="avatar"
                                                data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG"
                                                accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" data-height="200"
                                                data-show-remove="false" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Project Name<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" placeholder="Name"
                                                id="display_name" name="display_name"
                                                value="{{ isset($customer) ? $customer->display_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.primary_contact_name') }}</label>
                                            <input type="text" class="form-control mb-4" id="contact_name"
                                                name="contact_name"
                                                value="{{ isset($customer) ? $customer->contact_name : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.email') }}</label>
                                            <input type="text" class="form-control mb-4 check-email" id="email"
                                                name="email"
                                                value="{{ isset($customer) ? $customer->email : '' }}">
                                        </div>
                                    </div>
                                    @if(isset($user))
                                        <input type="hidden" class="form-control" id="flag" name="flag" value="1">
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{isset($customer) ? $customer->id : '0'}}">
                                    @else
                                        <input type="hidden" class="form-control" id="flag" name="flag" value="0">
                                    @endif

                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.password') }}</label>
                                            <input type="text" class="form-control mb-4" id="password" name="password" value="{{ isset($customer) ? '' : '123456' }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.phone_number') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control mb-4" id="phone" name="phone"
                                                value="{{ isset($customer) ? $customer->phone : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.primary_currency') }}</label>
                                            @php
                                                $currencies = App\Currency::get();
                                            @endphp
                                            <select name="currency" id="currency" class="form-control select2"
                                                data-placeholder="Choose one (with searchbox)">
                                                <option value="">--{{ __('all.choose_currency') }}--</option>
                                                @foreach ($currencies as $row)
                                                    <option value="{{ $row->code }}"
                                                        {{ isset($customer) && $customer->currency == $row->code ? 'selected' : '' }}>
                                                        {{ $row->code }}
                                                        ({{ $row->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('all.website') }}</label>
                                            <input type="text" class="form-control mb-4" id="website" name="website"
                                                value="{{ isset($customer) ? $customer->website : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-footer mt-2">
                            <button class="btn admin-submit-btn-grad next_btn" type="submit">{{ __('all.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('js')

@endpush
