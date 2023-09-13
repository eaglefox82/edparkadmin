@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div align="Center">
        <h1>Squadron Members</h1>
    </div>
@stop

@section('content')

    <div class="container-fluid">
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
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $members->where('gender', 'M')->count() }}</h3>
                        <p>Male Members</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-fuchsia">
                    <div class="inner">
                        <h3>{{ $members->where('gender', 'F')->count() }}</h3>
                        <p>Female Members</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percent"></i>
                    </div>
                </div>
            </div>

              <div class="col-lg-3 col-sm-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Members to follow up</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percent"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>

@stop
