@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            All Requests
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">All Requests</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">All Requests</h3>

                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <div class="btn-group">
                                    <a href="{{url('requests/new')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Request</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <!-- /.box-header -->
                    <div class="row">
                        <div class="col-md-6">
                            @include('partials.statuses')
                        </div>
                    </div>

                    <div class="box-body ">
                        <div class="row"></div>
                        {{-- <div class="table-responsive mailbox-messages"> --}}
                        <?php
                        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
                        $role_id = \App\Libraries\Utilities::getUserRole($user_id);
                        ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Item [Current Stock]</th>
                                <th>Request Type</th>
                                <th>Requested Quantity</th>
                                <th>Request Details</th>
                                <th>Added On</th>
                                <th>Added By</th>
                                <th>Status</th>
                                <th>Supervisor Comments</th>
                                @if($role_id == 2)
                                <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($requests))
                                <?php $i = 0; ?>
                                @foreach($requests as $request)
                                    <?php $i++;
                                    $date_added = date('d-m-Y', strtotime($request->created_at));
                                    $comments = \App\Libraries\Utilities::getSupervisorComments($request->request_id);
                                    ?>
                                    <tr>
                                        <td >{{$i}}</td>
                                        <td>{{$request->item}}[{{$request->current_quantity}}]</td>
                                        <td>{{$request->category}}</td>
                                        <td>{{$request->quantity}}</td>
                                        <td>{{$request->reason}}</td>
                                        <td>{{$date_added}}</td>
                                        <td>{{$request->fullname}}</td>
                                        <td>{{$request->status}}</td>
                                        <td>
                                            @if(!empty($comments))
                                                @foreach($comments as $comment)
                                                    <?php $created_at = date('d-m-Y', strtotime($comment->created_at)); ?>
                                                    <p>{{$comment->comment}}</p>
                                                        <em>[{{$comment->name}}  - {{$created_at}}]</em>
                                                @endforeach
                                            @else
                                                <p>None available</p>
                                            @endif
                                        </td>
                                        @if($role_id == 2)
                                        <td>
                                            @if($request->status_id == 1)
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal" data-target="#{{$request->request_id}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                                            </div>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    <!-- /.mail-box-messages -->
                                    <div class="modal fade" id="{{$request->request_id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>

                                                    <h4 class="modal-title">[Update Status]</h4>

                                                </div>
                                                <form class="" method="post" action="">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                    <div class="modal-body">
                                                        <p>
                                                            <label>Status</label>
                                                            <select name="status_id" class="form-control" required>
                                                                <option value="">--Please select--</option>
                                                                @foreach($statuses as $status)
                                                                <option value="{{$status->id}}">{{$status->status}}</option>
                                                                @endforeach
                                                            </select>
                                                        </p>
                                                        <p>
                                                            <label>Comment[Not compulsory]</label>
                                                            <textarea name="comments" class="form-control"></textarea>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
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
            $('#example1').DataTable()
        })
    </script>
@endsection