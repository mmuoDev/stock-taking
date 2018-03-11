@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Dashboard</h3>


                    </div>


                    <div class="box-body ">
                        <div class="row"></div>
                        {{-- <div class="table-responsive mailbox-messages"> --}}
                        <div class="row">
                            <div class="panel-group">
                            <div class="col-md-9">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading"><h5>New Requests</h5></div>
                                        <div class="panel-body">
                                            <table id="example1" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Item [Current Stock]</th>
                                                    <th>Requested Quantity</th>
                                                    <th>Reason for Request</th>
                                                    <th>Request Category</th>
                                                    <th>Date Added</th>
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
                                                            <td>{{$request->item}}</td>
                                                            <td>{{$request->quantity}}</td>
                                                            <td>{{$request->reason}}</td>
                                                            <td>{{$request->category}}</td>
                                                            <td>{{$date_added}}</td>
                                                        </tr>

                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            <div class="col-md-3">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">Items with least stock</div>
                                    <div class="panel-body">
                                        <table id="example1" class="table table-bordered table-responsive">
                                            <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Item Name</th>
                                                <th>Current Stock</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($stocks))
                                                <?php $i = 0; ?>
                                                @foreach($stocks as $stock)
                                                    <?php $i++;
                                                    //$date_added = date('d-m-Y', strtotime($request->created_at));
                                                    ?>
                                                    <tr>
                                                        <td >{{$i}}</td>
                                                        <td>{{$stock->item_name}}</td>
                                                        <td>{{$stock->current_quantity}}</td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--Chart -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>

                        </div>
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
            $('table#example1').DataTable(
                {
                    searching: false,
                    "paging": false
                }
            )
        })
    </script>
@endsection