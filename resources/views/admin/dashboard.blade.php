@extends('layouts.admin-layout')
@section('title','Dashboard')
@push('js')
    <script src="{{asset('assets/backend/plugins/chart.js/Chart.min.js')}}"></script>
@endpush
@section('content')
    @php
        $settings = new App\MasterSetting();
        $site = $settings->siteData();
        $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.today_invoice')}}</span>
                        <span
                            class="info-box-number"> {{$currency}} {{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->sum('total')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-receipt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.this_month_total_invoice')}}</span>
                        <span
                            class="info-box-number"> {{$currency}} {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->sum('total')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-wallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.today_payment')}}</span>
                        <span
                            class="info-box-number">{{$currency}}{{App\Invoice::where('invoice_date',\Carbon\Carbon::today())->sum('paid')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-3">
                    <span class="info-box-icon admin-widget-black"><i class="fas fa-wallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('all.this_month_total_payment')}}</span>
                        <span
                            class="info-box-number">{{$currency}}  {{App\Invoice::whereBetween('invoice_date',[\Carbon\Carbon::now()->startOfMonth(),\Carbon\Carbon::now()->endOfMonth()])->sum('paid')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        /* Income and Espense*/
        "use strict";
        var cDataInvoice = JSON.parse(`<?php echo $chart_data_invoice; ?>`);
        var ctxInvoice = document.getElementById('invoice-status-chart').getContext('2d');
        var myChartInvoice = new Chart(ctxInvoice, {
            type: 'bar',
            data: {
                labels: cDataInvoice.label,
                datasets: [{
                    label: 'Invoice and Expense',
                    data: cDataInvoice.data,
                    backgroundColor: [
                        'rgb(38,38,38)',
                        'rgb(62,62,62)',
                        'rgb(108,117,125)',
                        'rgb(206,212,218)',
                        'rgb(222,226,230)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(0,0,0)',
                        'rgb(50,50,50)',
                        'rgb(33,37,41)',
                        'rgb(52,58,64)',
                        'rgb(73,80,87)',
                        'rgb(0,0,0)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        /* expense chart */
        "use strict";
        var cDataExpense = JSON.parse(`<?php echo $chart_data_expense; ?>`);
        var ctxExpense = document.getElementById('customer-status-chart').getContext('2d');
        var myChartCustomer = new Chart(ctxExpense, {
            type: 'pie',
            data: {
                labels: cDataExpense.label,
                datasets: [{
                    label: 'Expenses',
                    data: cDataExpense.data,
                    backgroundColor: [
                        'rgb(38,38,38)',
                        'rgb(62,62,62)',
                        'rgb(108,117,125)',
                        'rgb(206,212,218)',
                        'rgb(222,226,230)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgb(0,0,0)',
                        'rgb(50,50,50)',
                        'rgb(33,37,41)',
                        'rgb(52,58,64)',
                        'rgb(73,80,87)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
