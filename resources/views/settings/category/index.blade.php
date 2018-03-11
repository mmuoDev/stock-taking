@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Items Categories
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Item Categories</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Item Categories</h3>

                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <div class="btn-group">
                                    <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Category</button>
                                </div>
                            </div>
                        </div>
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
                                        <th>Name</th>
                                        <th>Added On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($categories))
                                    <?php $i = 0; ?>
                                    @foreach($categories as $category)
                                        <?php $i++;
                                        $date_added = date('d-m-Y', strtotime($category->created_at));
                                        ?>
                                        <tr>
                                            <td >{{$i}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$date_added}}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" data-toggle="modal" data-target="#{{$category->id}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit categories -->
                                        <div class="modal fade" id="{{$category->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">[Edit Category]</h4>
                                                    </div>
                                                    <form class="" method="post" action="{{url('settings/category/update')}}">
                                                        {{csrf_field()}}
                                                        <div class="modal-body">
                                                            <p>
                                                                <label>Name</label>
                                                                <input type="text" name="name" value="{{$category->name}}" placeholder="Enter category" class="form-control">
                                                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                            <!-- /.mail-box-messages -->
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">New Category</h4>
                                        </div>
                                        <form class="" method="post" action="{{url('settings/category/create')}}">
                                            {{csrf_field()}}
                                        <div class="modal-body">
                                            <p>
                                                <label>Name</label>
                                                <input type="text" name="name" placeholder="Enter category" class="form-control">
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
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