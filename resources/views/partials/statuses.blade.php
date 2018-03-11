@if(isset($errors))
    @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endForeach
                </ul>
            </div>
    @endIf
@endIf

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif