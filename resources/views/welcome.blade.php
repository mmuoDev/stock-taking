<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The StockTAKING Cloud Solution for SMEs</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap/css/bootstrap.min.css')}}">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

    <!-- Custom styles for this template -->
    {{--
    <link href="{{asset('css/coming-soon.min.css')}}" rel="stylesheet">
    --}}
    <link rel="stylesheet" href="{{asset('css/coming-soon.css')}}">

</head>

<body>

<div class="overlay"></div>

<div class="masthead">
    <div class="masthead-bg"></div>
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-12 my-auto">
                <div class="masthead-content text-white py-5 py-md-0">
                    <h1 class="mb-3">The StockTAKING App <small><em>for SMEs.</em></small></h1>
                    <p class="mb-5">This is a cloud-based solution that enables SMEs manage their inventory effortlessly.
                    </p>
                    <div class="">
                        <button class="btn btn-warning btn-lg" type="button" data-toggle="modal" data-target="#myModal">Features</button>
                        <a href="{{url('/login')}}"><button class="btn btn-default btn-lg">Try It</button></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h5 class="modal-title">[Features]</h5>
            </div>
            <div class="modal-body">
                <p>
                    <ul>
                        <li>Add all items available in your store or warehouse.</li>
                        <li>You can categorize items under different categories.</li>
                        <li>Request system to checkmate how items are added or removed from your store. Store keepers must
                        send requests to store supervisors and these supervisors must approve before items are removed from the store.</li>
                        <li>You can track all requests made on any item if a conflict arises</li>
                        <li>You can add users under categories - store keeper and supervisor.</li>
                        <li>You can see the current available quantity for every item in your store.</li>
                        <li>Email and in-app notifications available</li>
                    </ul>
                    You can try our solution by signing up <a href="{{url("/register")}}">here</a><br>
                    Feel free to contact us on +2348063321043 to upgrade your plan.

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

{{--<div class="social-icons">--}}
    {{--<ul class="list-unstyled text-center mb-0">--}}
        {{--<li class="list-unstyled-item">--}}
            {{--<a href="#">--}}
                {{--<i class="fa fa-twitter"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class="list-unstyled-item">--}}
            {{--<a href="#">--}}
                {{--<i class="fa fa-facebook"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class="list-unstyled-item">--}}
            {{--<a href="#">--}}
                {{--<i class="fa fa-instagram"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</div>--}}

<!-- Bootstrap core JavaScript -->
<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Plugin JavaScript -->
<script src="{{asset('js/vide/jquery.vide.min.js')}}"></script>

<!-- Custom scripts for this template -->
<script src="{{asset('js/coming-soon.min.js')}}"></script>

</body>

</html>