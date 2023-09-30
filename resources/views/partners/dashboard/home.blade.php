@section('title')
    {{title( 'DASHBOARD' )}}
@endsection
@extends('layouts.main')
<?php
/**
 * @var \App\Models\SousServices[] $services ;
 */
?>
@section('page')

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
        </div>
        <div class="col-md-12">
            @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
        </div>
        <!-- card1 start -->
        <div class="col-md-12 col-xl-12">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-home bg-c-blue card1-icon"></i>
                    @if(getUser()->is_admin)
                        <span class="text-c-blue f-w-600">{{getUser()->name}}</span>
                    @endif
                    @if(!getUser()->is_admin)
                        <span class="text-c-blue f-w-600">{{user_partner()->name}}</span>
                    @endif
                    <div>
                        <span class="f-left m-t-10  m-4">
                            <i class="text-c-blue f-16 icofont icofont-home m-r-10"></i>Bienvenue dans la plateforme INTECH API
                        </span>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{asset('assets/pages/dashboard/custom-dashboard.js')}}"></script>
@endsection
