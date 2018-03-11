@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Items
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Items</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Add Item</h3>
                        {{--
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <div class="btn-group">
                                    <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Category</button>
                                </div>
                            </div>
                        </div>
                        --}}
                        <!-- /.box-tools -->
                    </div>
                    -
                    <!-- /.box-header -->
                    <div class="row">
                        <div class="col-md-6">
                            @include('partials.statuses')
                        </div>
                    </div>


                    <form role="form" method="post" action="" accept-charset="UTF-8" id="users-form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputN">Item Name</label>
                                        <input type="text" class="form-control" id="exampleInputN"
                                               placeholder="Item Name" name="name" required value="{{old('name')}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputFolderName">Item Code</label>
                                        <input type="text" class="form-control" placeholder="Enter Item Code"
                                               name="code" value="{{old('code')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="text-box form-group">
                                        <label for="exampleInputFile">Category</label>
                                        <select name="category_id" id="input" class="form-control" required="required">
                                            <option value="">--Please select--</option>
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Date Added</label>
                                        <input type="text" placeholder="Date added" required id="datepicker" name="date_added" class="form-control" value="{{old('date_added')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="exampleInputFile">Item Description</label>
                                    <div class="well">
                                        <div class="text-box form-group">
                                            <textarea name="description" placeholder="Describe this item" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <center>
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </center>
                        </div>
                    </form>

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
            $('#datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
        });
    </script>
@endsection