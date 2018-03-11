@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Stocks
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Stocks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Stocks</h3>
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
                                <th>Item [Category]</th>
                                <th>Item Code</th>
                                <th>Previous Quantity</th>
                                <th>Current Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($stocks))
                                <?php $i = 0; ?>

                                @foreach($stocks as $stock)
                                    <?php $i++;
                                    //$date_added = date('d-m-Y', strtotime($item->date_added));
                                        $current = $stock->current_quantity;
                                        $previous = $stock->prev_quantity;
                                    ?>
                                    <tr>
                                        <td >{{$i}}</td>
                                        <td>{{$stock->item_name}}[{{$stock->category}}]</td>
                                        <td>{{$stock->code}}</td>
                                        <td>{{$stock->prev_quantity}}</td>
                                        <td>
                                            {{$stock->current_quantity}}
                                            @if($current > $previous)
                                                <i class="fa fa-arrow-up" style="color:green"></i>
                                            @elseif($current < $previous)
                                                <i class="fa fa-arrow-down" style="color:red"></i>
                                            @else
                                                <i class="fa fa-arrows-alt-h"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{url('stocks/requests/'.$stock->uri)}}"> <button type="button"  data-title="Requests History" data-toggle="modal" class="btn btn-default btn-sm"><i class="fa fa-history"></i></button></a>
                                            </div>
                                        </td>
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