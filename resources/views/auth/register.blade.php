@extends('layouts.auth.main')
@section('content')
    <div class="col-md-6 right-side">
        <h3></h3>

        <!--Form with header-->
        <form class="form-horizontal" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form">
                <div class="form-group">
                    <span style="font-size: 17px; ">Only one signup required per company.</span>
                </div>
                {{--
                <div class="form-group">
                    @if(isset($errors))
                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <span style="color: red; font-size: 17px;">{{$error}}</span>
                            @endForeach
                        @endIf
                    @endIf
                </div>
                --}}
                <div class="form-group">
                    <label for="form2">Company Name</label>
                    <input type="text" id="form2" class="form-control" name="name" placeholder="E.g. Classy Painters Ltd" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="form2">E-mail</label>
                    <input type="text" id="form2" class="form-control" placeholder="E.g. admin@classy.com" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="form4">Password</label>
                    <input type="password" id="form4" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="form4">Confirm Password</label>
                    <input type="password" id="form4" class="form-control" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label for="form2">Company Logo</label>
                    <input type="file" id="form2" class="form-control" name="file">
                    @if ($errors->has('file'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="text-xs-center">
                        <button type="submit" class="btn btn-deep-purple">Register</button>
                    </div>
                </div>

                <div class="form-group">
                    <span style="font-size: 17px;">Already have an account? <a href="{{url('login')}}" style="color: red;">Login here.</a></span>
                </div>
            </div>
            <!--/Form with header-->
        </form>

    </div><!--col-sm-6-->
@stop