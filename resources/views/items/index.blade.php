@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            All Items
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Items</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">All Items</h3>
                        <!-- /.box-tools -->
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <div class="btn-group">
                                    <a href="{{url('items/add')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Item</a>
                                </div>
                            </div>
                        </div>
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
                                <th>Date Added</th>
                                <th>Added By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($items))
                                <?php $i = 0; ?>

                                @foreach($items as $item)
                                    <?php $i++;
                                    $date_added = date('d-m-Y', strtotime($item->date_added));
                                    ?>
                                    <tr>
                                        <td >{{$i}}</td>
                                        <td>{{$item->name}}[{{$item->category}}]</td>
                                        <td>{{$item->code}}</td>
                                        <td>{{$date_added}}</td>
                                        <td>{{$item->user_name}}</td>
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