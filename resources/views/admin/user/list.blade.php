@extends('admin.layout.master')

@section('title', 'User List')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($result as $index => $res)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $res->name }}</td>
                                                    <td>{{ $res->email }}</td>
                                                    <td id="status-{{ $res->id }}">
                                                        @if($res->status == '1')
                                                        <button type="button" class="btn btn-block bg-gradient-success btn-sm">Enabled</button>
                                                        @else
                                                        <button type="button" class="btn btn-block bg-gradient-danger btn-sm">Disabled</button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="status-checkbox" data-id="{{ $res->id }}" {{ $res->status == 1 ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-checkbox').on('change', function() {
            var userId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("update.status") }}',
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: userId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        var button = $('#status-' + userId + ' button');
                        if (status == 1) {
                            button.removeClass('bg-gradient-danger').addClass('bg-gradient-success').text('Enabled');
                        } else {
                            button.removeClass('bg-gradient-success').addClass('bg-gradient-danger').text('Disabled');
                        }
                    } else {
                        alert('Failed to update status');
                    }
                }
            });
        });
    });
</script>

@endsection