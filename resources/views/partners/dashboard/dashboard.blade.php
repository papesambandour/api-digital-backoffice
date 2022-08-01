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
        <!-- card1 start -->
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">SOLDE</span>
                    <h4 class="currency">{{_auth()['solde']}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 icofont icofont-warning m-r-10"></i>Le solde du Compte Partenaire
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-ui-home  bg-c-green card1-icon"></i>
                    <span class="text-c-pink f-w-600">Transaction Succès</span>
                    <h4>{{amountState('SUCCESS')}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-pink f-16 icofont icofont-calendar m-r-10"></i>Journée en cours
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-warning-alt bg-c-pink card1-icon"></i>
                    <span class="text-c-green f-w-600">Transactions Échec</span>
                    <h4>{{amountState('FAILLED')}} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-green f-16 icofont icofont-calendar m-r-10"></i>Journée en cours
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- card1 start -->
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="icofont icofont-money bg-c-yellow card1-icon"></i>
                    <span class="text-c-yellow f-w-600">Transactions En cours</span>
                    <h4> {{amountState('PENDING') + amountState('PROCESSING') }} XOF</h4>
                    <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-yellow f-16 icofont icofont-calendar m-r-10"></i>Journée en cours
                                                            </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 end -->
        <!-- Statestics Start -->
       {{-- <div class="col-md-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Statestics</h5>
                    <div class="card-header-left ">
                    </div>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="icofont icofont-simple-left "></i></li>
                            <li><i class="icofont icofont-maximize full-card"></i></li>
                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                            <li><i class="icofont icofont-error close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div id="statestics-chart" style="height:517px;"></div>
                </div>
            </div>
        </div>--}}




        <!-- Email Sent End -->
        <!-- Data widget start -->
        <div class="col-md-12 col-xl-12">
            <div class="card project-task">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Montant par services Journée {{gmdate('Y-m-d')}}</h5>
                    </div>

                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Libelle</th>
                                <th style="text-align: center">Montants succès</th>
                                <th style="text-align: center">Taux de réussite</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-blue d-inline-block text-center">{{logoFromName($service->name)}}</h6>
                                            <p class="d-inline-block m-l-20">{{$service->name}}</p>
                                        </div>
                                    </td>
                                    @php
                                    $amount = getAmountTransactionByServices($service->id);
                                     $percentage =  percentage($amount,$service->id)
                                    @endphp
                                    <td style="text-align: center">
                                        <p class="d-inline-block currency" style="">{{$amount}} <span >XOF</span></p>
                                    </td>
                                    <td style="text-align: center">
                                        {{$percentage}} %
                                    </td>
                                    <td style="width: 300px">
                                        <div class="progress d-inline-block" style="width: 100%">


                                            <div class="progress-bar bg-c-blue"
                                                 role="progressbar" aria-valuemin="0"
                                                 aria-valuemax="100" style="width:{{$percentage}}%">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data widget End -->

    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{asset('assets/pages/dashboard/custom-dashboard.js')}}"></script>
@endsection
