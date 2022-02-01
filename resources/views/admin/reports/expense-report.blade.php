@extends('layouts.admin-layout')
@section('title', 'Expense Report')
@section('content')
    <div class="content p-3">
        <div class="card card-outline shadow-3">
            <div class="card-body pb-0 shadow-3">
                <form method="post" action="/admin/reports/expense">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Expense date</label>
                            <input type="date" name="date"  class="form-control" placeholder="Date" value="{{$date?$date:''}}">
                        </div>
                    </div>
                    @php
                        $projects = App\Customer::latest()->get();
                    @endphp
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Project</label>
                            <select class="form-control select2" name="project">
                                <option value="">--All Projects--</option>
                                @foreach ($projects as $items)
                                <option {{$project_id==$items->id?'selected':''}} value="{{$items->id}}">{{ $items->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $category = App\ExpenseCategory::latest()->get();
                    @endphp
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Expense category</label>
                            <select class="form-control select2" name="category">
                                <option value="">--All Expense category--</option>
                                @foreach ($category as $categories)
                                    <option {{$category_id== $categories->id?'selected':''}} value="{{$categories->id}}">{{ $categories->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary mb-5" value="Filter Expense">
                    </div>

                </div>
                </form>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card card-outline shadow-3">
                                <div class="card-header admin-cart-header">
                                    <h3 class="card-title">Reports</h3>
                                </div>
                                <div class="card-body table-responsive">
                                        <table class="table table-bordered"
                                               id="expense_report" >
                                            <thead>
                                            <tr role="row">
                                                <th class="border-bottom-0">Sl.
                                                </th>
                                                <th class="border-bottom-0">Project
                                                </th>
                                                <th class="border-bottom-0">Category
                                                </th>
                                                <th class="border-bottom-0">Sub Category
                                                </th>
                                                <th class="border-bottom-0">Voucher No
                                                </th>
                                                <th class="border-bottom-0">Amount (BDT)
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($get_report) > 0)
                                                @foreach ($get_report as $key=>$row)
                                                    <tr role="row" class="odd">
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $key+1 }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->project_name }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->expense_category }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->expense_sub_category }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                            <span>{{ $row->voucher }}</span></td>
                                                        <td class="text-nowrap align-middle">
                                                           {{ $row->amount }}</td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align:right">Total:</th>
                                                <th>{{$get_report->sum('amount')}}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

    <script>
        $(document).ready(function() {
            $('#expense_report').DataTable( {
                dom: 'Bfrti',
                responsive: true,
                "autoWidth": false,
                buttons: [
                    'csv', 'excel', 'print'
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                       'BDT '+ total
                    );
                }
            } );
        } );
    </script>
@endpush
