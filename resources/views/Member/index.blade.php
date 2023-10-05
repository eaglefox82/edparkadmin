@extends('adminlte::page')

@section('title', 'Members')

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
                        <h3>{{ $members->where('gender', 'M')->count() }} <small>( {{ ($members->where('gender', 'M')->count() / $members->count() )*100}}%)</small></h3>
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
                        <h3>{{ $members->where('gender', 'F')->count() }} <small>( {{ ($members->where('gender', 'F')->count() / $members->count() )*100}}%)</small></h3>
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

        @php
            $config = [
                'processing' => true,
                'serverSide' => true,
                'ajax' => "{{ route('member.getmembers') }}",

            ];
        @endphp

        <x-adminlte-datatable id="members" :heads=$heads head-theme="dark" striped hoverable with-button beautify :config=$config>

        </x-adminlte-datatable>

    </div>

@endsection


