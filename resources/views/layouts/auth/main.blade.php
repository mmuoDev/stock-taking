<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=latin-ext');


    #playground-container {
        height: 500px;
        overflow: hidden !important;

    }
    .main{margin-top:70px;
        -webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.1);
        padding:0px;
        background:#2196f3;
    }
    .fb:focus, .fb:hover{color:FFF !important;}
    body{
        font-family: 'Raleway', sans-serif;
    }

    .left-side{
        padding:0px 0px 0px;

        background-size:cover;
    }
    .left-side h3{
        font-size: 30px;
        font-weight: 900;
        color:#FFF;
        padding: 50px 10px 00px 26px;
    }

    .left-side p{
        font-weight:600;
        color:#FFF;
        padding:10px 10px 10px 26px;
    }


    .fb{background: #2d6bb7;
        color: #FFF;
        padding: 10px 15px;
        border-radius: 18px;
        font-size: 12px;
        font-weight: 600;
        margin-right: 15px;
        margin-left:26px;-webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);}
    .tw{background: #20c1ed;
        color: #FFF;
        padding: 10px 15px;
        border-radius: 18px;
        font-size: 12px;
        font-weight: 600;
        margin-right: 15px;-webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);}

    .right-side{
        padding:0px 0px 0px;
        background:#FFF;
        background-size:cover;
        min-height:514px;
    }
    .right-side h3{
        font-size: 30px;
        font-weight: 700;
        color:#000;
        padding: 50px 10px 00px 50px;
    }
    .right-side p{
        font-weight:600;
        color:#000;
        padding:10px 50px 10px 50px;
    }
    .form{padding:10px 50px 10px 50px;}
    .form-control{box-shadow: none !important;
        border-radius: 0px !important;
        border-bottom: 1px solid #2196f3 !important;
        border-top: 1px !important;
        border-left: none !important;
        border-right: none !important;}
    .btn-deep-purple {
        background: #2196f3;

        padding: 5px 19px;
        color: #FFF;
        font-weight: 600;
        float: right;
        -webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
        box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.24);
    }
</style>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">

    <div class="col-md-10 col-md-offset-1 main" >
        <div class="col-md-6 left-side text-center" style="margin-top: 50px;">
            <h3>The stockTAKING App</h3>
            <p>The Stock Management Solution for SMEs.</p>
            <br>
        </div><!--col-sm-6-->
        @yield('content')



    </div><!--col-sm-8-->

</div><!--container-->