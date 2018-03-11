@extends('layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Requests
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Make Request</li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Make Request</h3>
                        <?php   $count = \App\User::where('role_id', 2)->count(); ?>
                        @if($count == 0)
                        <h5 class="text-danger">There are no supervisors to handle requests. Requests can't be sent! Advise your admin to add a supervisor.</h5>
                        @endif
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


                    <form role="form" method="post" action="{{url('requests/new')}}" accept-charset="UTF-8" id="users-form">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered" id="items">
                                        <thead>
                                        <tr style="background-color: #f9f9f9;">
                                            <th width="5%"  class="text-center">Actions</th>
                                            <th width="20%" class="text-left">Select Item [Current Stock]</th>
                                            <th width="20%" class="text-left">Select Request Category</th>
                                            <th width="20%" class="text-left">Quantity</th>
                                            <th width="30%" class="text-left">Explain Request</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $item_row = 0; ?>
                                        <tr id="item-row-{{ $item_row }}">
                                            <td class="text-center" style="vertical-align: middle;">
                                                <button type="button"  onclick="$(this).tooltip('destroy'); $('#item-row-{{ $item_row }}').remove();" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                            </td>
                                            <td>
                                                <select name="item[{{ $item_row }}][item_id]" class="form-control iop" id='item-item_id-'. {{$item_row}}>
                                                    @if(isset($items))
                                                        @foreach($items as $item)
                                                            <option value="{{$item->item_id}}">{{$item->item_name}}[{{$item->current_quantity}}]</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="item[{{ $item_row }}][category_id]" class="form-control iop" id='item-category_id-'. {{$item_row}}>
                                                    @if(isset($categories))
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control typeahead" required placeholder="Quantity" name="item[{{ $item_row }}][quantity]" type="number" id="item-quantity-{{ $item_row }}">
                                            </td>
                                            <td>
                                                <textarea name="item[{{ $item_row }}][reason]" id="item-reason-{{ $item_row }}" placeholder="Describe this request in details" class="form-control" required>{{old('reason')}}</textarea>
                                            </td>
                                        </tr>
                                        <?php $item_row++; ?>
                                        <tr id="addItem">
                                            <td class="text-center"><button type="button" onclick="addItem();" data-toggle="tooltip" title="" class="btn btn-xs btn-primary" data-original-title=""><i class="fa fa-plus"></i></button></td>
                                            {{--
                                            <td class="text-right" colspan="5"></td> --}}
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{--
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputN">Select Item</label>
                                        <select name="item_id" id="input" class="form-control" required="required">
                                            <option value="">--Please select--</option>
                                            @if(isset($items))
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputFolderName">Select Request Category</label>
                                        <select name="category_id" id="input" class="form-control" required="required">
                                            <option value="">--Please select--</option>
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-box form-group">
                                        <label for="exampleInputFile">Quantity</label>
                                        <input type="number" placeholder="E.g. 56, 8.9, etc." required name="quantity" class="form-control" value="{{old('quantity')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Explain Request</label>
                                        <textarea name="description" placeholder="Describe this request in details" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            --}}
                        </div>

                        <div class="box-footer">

                                <button type="submit" class="btn btn-primary" id="submit_btn">Send Request</button>
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

        //$(function () {
        var count = '<?php echo $count; ?>';
        console.log(count);
        if(count == 0){
            document.getElementById('submit_btn').disabled = true;
        }
        $('#datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
        //});
        var item_row = '{{ $item_row }}';
        function addItem() {
            html  = '<tr id="item-row-' + item_row + '">';
            html += '  <td class="text-center" style="vertical-align: middle;">';
            html += '      <button type="button" onclick=" $(\'#item-row-' + item_row + '\').remove();" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';
            html += '  </td>';
            html += '  <td>';
            html += '      <select  class="form-control select2" name="item[' + item_row + '][item_id]" id="item-item_id-' + item_row + '">';
            // html += '         <option selected="selected" value="">--Please select--</option>';
            @if(isset($items))
                @foreach($items as $item)
                html += '<option value="{{$item->item_id}}">{{$item->item_name}}[{{$item->current_quantity}}]</option>';
                @endforeach
            @endif
                    html += '</select>';
            html += '  </td>';
            html += '  <td>';
            html += '      <select  class="form-control select2" name="item[' + item_row + '][category_id]" id="item-category_id-' + item_row + '">';
            // html += '         <option selected="selected" value="">--Please select--</option>';
            @if(isset($categories))
                    @foreach($categories as $category)
                html += '<option value="{{ $category->id }}">{{ $category->category }}</option>';
            @endforeach
                    @endif
                html += '</select>';
            html += '  </td>';
            html += '  <td>';
            html += '      <input class="form-control" placeholder="Quantity" required="required" name="item[' + item_row + '][quantity]" type="number" id="item-quantity-' + item_row + '">';
            html += '  </td>';
            html += '  <td>';
            html += '      <textarea class="form-control" placeholder="Describe this request in details" required="required" name="item[' + item_row + '][reason]" id="item-reason-' + item_row + '"></textarea>';
            html += '  </td>';


            $('#items tbody #addItem').before(html);
            //$('[rel=tooltip]').tooltip();

            $('[data-toggle="tooltip"]').tooltip('hide');

            $('#item-row-' + item_row + ' .select2').select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.taxes', 1)]) }}"
            });

            item_row++;
        }
    </script>
@endsection