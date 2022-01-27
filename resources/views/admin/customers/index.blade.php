@extends('layouts.admin-layout')
@section('title', 'Customers')
@section('content')
    <div class="content p-3">
        <section class="content">
            <div class="card card-outline shadow-3">
                <div class="card-header admin-cart-header">
                    <h3 class="card-title">{{ __('all.customers') }}</h3>
                    <a href="{{ url('admin/customers/create') }}" class="btn btn-xs admin-submit-btn-grad float-right"><i
                            class="fa fa-plus"></i>{{ __('all.add_new_customer') }}</a>
                </div>
                <div class="card-body pb-0 shadow-3">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Company Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($customers) > 0)
                            @foreach ($customers as $key=> $row)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $row->display_name }}</td>
                            <td>{{ $row->contact_name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td><div class="text-center">
                                    <a href="{{ url('admin/customers/update/' . $row->id) }}" class="btn btn-sm bg-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ url('admin/customers/delete/' . $row->id) }}" class="delete-btn btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div></td>
                        </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if (count($customers) > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination justify-content-end">
                                        {!! $customers->links() !!}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(function () {

            $('.data-table').DataTable( {
                responsive: true,
                searching: true
            } );

        });
    </script>
@endsection

