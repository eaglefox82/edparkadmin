@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div align="Center">
        <h1>Dashboard</h1>
    </div>
@stop

@section('content')
    <div align="Center">
        <p>Welcome to our Admin Panel</p>
    </div>

   <div class="content">
    <div class="container fluid">

        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h6>Todays Date: <?php echo date('l - jS F Y') ?></h6>
                    <h6>Current Roll Date:</h6>
                </div>

            </div>
        </div>

        @if ($monthlyreports == "Y")
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <h5>
                            <i class="icon fas fa-exclamation-triangle"></i>
                            Alert!
                        </h5>
                        Monthly Reports need to be completed.
                    </div>
                </div>
            </div>
        @endif

        <div class="row">

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $members->count() }}</h3>
                        <p>Members on Roll</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                 <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $monthlyreports }}</h3>
                        <p>Members Present</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>80%</h3>
                        <p>Squadron Attendance</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percent"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

             <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-fuchsia">
                    <div class="inner">
                        <h3>1</h3>
                        <p>Upcoming Birthdays</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>


        <div class="row">

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>50</h3>
                        <p>Officers Present</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-astronaut"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                 <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>50</h3>
                        <p>WO's Present</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-lime">
                    <div class="inner">
                        <h3>80%</h3>
                        <p>NCO's Present</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-angle-double-down"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

             <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>1</h3>
                        <p>Cadets Present</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>


        <div class="row">

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-lightblue">
                    <div class="inner">
                        <h3>50</h3>
                        <p>Outstanding Terms Fees</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                 <div class="small-box bg-navy">
                    <div class="inner">
                        <h3>50</h3>
                        <p>Squadron Yearly Attendance</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percent"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>80%</h3>
                        <p>Membership Increase YTD</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

             <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>1</h3>
                        <p>Trial Members</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-secret"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>


    </div>
   </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
