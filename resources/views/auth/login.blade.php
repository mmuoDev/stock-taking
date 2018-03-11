@extends('layouts.auth.main')
@section('content')
    <div class="col-md-6 right-side">
        <h3></h3>

        <!--Form with header-->
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
        <div class="form">
            <div class="form-group">
                @if(isset($errors))
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <span style="color: red; font-size: 17px;">{{$error}}</span>
                        @endForeach
                    @endIf
                @endIf
            </div>

            <div class="form-group">
                <label for="form2">E-mail</label>
                <input type="text" id="form2" class="form-control" name="email" value="{{ old('email') }}">

            </div>

            <div class="form-group">
                <label for="form4">Password</label>
                <input type="password" id="form4" class="form-control" name="password">

            </div>
            <div class="form-group">
                <div class="text-xs-center">
                    <button type="submit" class="btn btn-deep-purple">Login</button>
                </div>
            </div>

            <div class="form-group">
                <span style="font-size: 17px;">Don't have an account? <a href="{{url('register')}}" style="color: red;">create one here.</a></span>
            </div>
        </div>
        <!--/Form with header-->
        </form>

    </div><!--col-sm-6-->
@stop