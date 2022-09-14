@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Claim $claim ;
 */
?>
@section('page')

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4> Réclamation</h4>
                            <span class="currency">Ticket numéro : {{$claim->claim_ref}}   </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">


                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <!-- Contextual classes table starts -->
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-block table-border-style">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th># Id</th>
                                    <th class="text-left">{{$claim->id}}</th>
                                </tr>
                                <tr>
                                    <th> Motif</th>
                                    <th class="text-left">{{$claim->subject}}</th>
                                </tr>
                                <tr>
                                    <th> Message</th>
                                    <th class="text-left">{{$claim->message}}</th>
                                </tr>
                                <tr>
                                    <th> Statut</th>
                                    <th class="text-left">{!!claimStatut($claim->statut)!!}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')

@endsection

@section('css')
@endsection
