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
                                <th class="col-md-4"># Ticket</th>
                                <th class="text-center">{{$claim->claim_ref}}</th>
                            </tr>
                            <tr>
                                <th> Motif</th>
                                <td class="text-center">{{$claim->subject}}</td>
                            </tr>
                            <tr>
                                <th> Message</th>
                                <th class="text-center">{{$claim->message}}</th>
                            </tr>
                            <tr>
                                <th> Statut</th>
                                <td class="text-center">{!!claimStatut($claim->statut)!!} </td>
                            </tr>
                            <tr>
                                <th> Montent transaction</th>
                                <th class="text-center">{{$claim->transaction->amount}}</th>
                            </tr>



                            <tr>
                                <th> Ouvert par</th>
                                <td class="text-center">{{@$claim->userOpened->fullName}} </td>
                            </tr>
                            <tr>
                                <th> Fermer par</th>
                                <th class="text-center">{{@$claim->userClosed->fullName}}</th>
                            </tr>


                            <tr>
                                <th> Numéro client</th>
                                <td class="text-center">{{$claim->transaction->phone}}</td>
                            </tr>
                            <tr>
                                <th> ID transaction</th>
                                <th class="text-center">{{$claim->transaction->id}}</th>
                            </tr>
                            <tr>
                                <th> Ref transaction</th>
                                <td class="text-center">{{$claim->transaction->transaction_id}}</td>
                            </tr>
                            <tr>
                                <th> Service</th>
                                <th class="text-center">{{$claim->transaction->service_name}}</th>
                            </tr>
                            <tr>
                                <th>Sous Service</th>
                                <td class="text-center">{{$claim->transaction->sous_service_name}}</td>
                            </tr>
                            <tr>
                                <th>Statut Transaction</th>
                                <th class="text-center">{{$claim->transaction->statut}}</th>
                            </tr>
                            <tr>
                                <th>Type Opération Transaction</th>
                                <td class="text-center"><span class="currency">{{$claim->transaction->type_operation}}</span> </td>
                            </tr>
                            <tr>
                                <th>Commentaire</th>
                                <th class="text-center"><span class="">{{$claim->comment?: "n\a"}}</span> </th>
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
