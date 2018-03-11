@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Requests History
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requests History</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Request History for [{{$item_name}}]</h3>
                        <!-- /.box-tools -->
                    </div>
                    -
                    <!-- /.box-header -->
                    <div class="row">
                        <div class="col-md-6">
                            @include('partials.statuses')
                        </div>
                    </div>


                    <div class="box-body ">
                        <div class="row"></div>
                        {{-- <div class="table-responsive mailbox-messages"> --}}
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Requested Quantity</th>
                                <th>Request Category</th>
                                <th>Reason for Request</th>
                                <th>Requested By</th>
                                <th>Requested On</th>
                                <th>Request Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($requests))
                                <?php $i = 0; ?>

                                @foreach($requests as $request)
                                    <?php $i++;
                                    $date_added = date('d-m-Y', strtotime($request->created_at));
                                    ?>
                                    <tr>
                                        <td >{{$i}}</td>
                                        <td>{{$request->quantity}}</td>
                                        <td>{{$request->category}}</td>
                                        <td>{{$request->reason}}</td>
                                        <td>{{$request->name}}</td>
                                        <td>{{$date_added}}</td>
                                        <td>{{$request->status}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'csv'
                ]
            })
        })
    </script>
@endsection