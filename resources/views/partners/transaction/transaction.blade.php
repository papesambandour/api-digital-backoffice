@section('title')
    {{title( 'TRANSACTIONS' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Transactions[] $transactions ;
 * @var \App\Models\SousServices[] $sous_services ;
 */
?>
@section('page')

    <div class="page-wrapper">
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
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>{{$title}}</h4>
                            <span>{{$subTitle}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{--IMPORT BUTTON START--}}
                    <button onclick="exportExcel('import-excel','Transaction')"    type="button" id="import-excel"
                            class="primary-api-digital btn btn-primary btn-outline-primary import-excel">
                        <i title="" class="ti-import "></i>
                        <span style=""> Exporter Excel</span>
                        <i hidden id="import-excel-sniper" class="fas fa-spinner fa-pulse"></i>
                    </button>
                    {{--IMPORT BUTTON END--}}
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <!-- Contextual classes table starts -->
            <div class="card">
                <div class="card-header">
                    <h5>Filtres</h5>
                    <div class="card-block">
                        <form>
                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Date de d??but</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de d??but">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Date de fin</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                                {{--                 DATE START                --}}
                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Transaction ID</label>
                                <div class="col-sm-2">
                                    <input value="{{$search_in_any_id_transaction}}" name="search_in_any_id_transaction"
                                           id="search_in_any_id_transaction" type="text"
                                           class="form-control form-control-normal" placeholder="Transaction ID">
                                </div>
                                {{--                 DATE START                --}}
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Services</label>
                                <div class="col-sm-2">
                                    <select name="sous_services_id" id="sous_services_id" class=""
                                            placeholder="Services">
                                        <option value="" selected> S??lectionnez un service</option>

                                        @foreach($sous_services as $sous_service)
                                            <option @if($sous_services_id ==  $sous_service->id) selected
                                                    @endif value="{{$sous_service->id}}"> {{$sous_service->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Statut transaction </label>
                                <div class="col-sm-2">
                                    <select name="statut" id="statut" class=""
                                            placeholder="Services">
                                        <option value="" selected> S??lectionnez une statut</option>

                                        @foreach($statuts as $s)
                                            <option @if($statut ==  $s) selected
                                                    @endif value="{{$s}}"> {{$s}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-2 col-form-label">Num??ro de t??l??phone</label>
                                <div class="col-sm-2">
                                    <input value="{{$phone}}" name="phone" id="phone" type="text"
                                           class="form-control form-control-normal" placeholder="Num??ro de t??l??phone">
                                </div>

                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Montant min</label>
                                <div class="col-sm-2">
                                    <input value="{{$amount_min}}" name="amount_min" id="amount_min" type="text"
                                           class="form-control form-control-normal" placeholder="Montant min">
                                </div>


                                <label class="col-sm-2 col-form-label">Montant max</label>
                                <div class="col-sm-2">
                                    <input value="{{$amount_max}}" name="amount_max" id="amount_max" type="text"
                                           class="form-control form-control-normal" placeholder="Montant max">
                                </div>


                                <div class="col-sm-2">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button onclick="window.location.href='/partner/transaction'" type="button"
                                            class="warning-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-delete"></i>Annuler
                                    </button>
                                </div>
                            </div>

                            <div>

                       </div>
                        </form>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                            <tr>
                                <th>Transaction Id</th>
                                <th>Num??ro </th>
                                <th>Montant</th>
                                <th>Type Operation</th>
                                <th>Commission</th>
                                <th>Frais</th>
                                <th>Services</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                {{--class="{{status($transaction->statut)}}"--}}
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$transaction->transaction_id}}
                                        </span>
                                    </th>
                                    <td>{{ $transaction->phone }} </td>
                                    <td class="currency">{{ $transaction->amount }} <span>XOF</span></td>
                                    <td> <span class="statut-success">{{$transaction->type_operation}} </span> </td>
                                    <td class="currency">{{ $transaction->commission_amount }} <span>XOF</span></td>
                                    <td class="currency">{{ $transaction->fee_amount }} <span>XOF</span></td>
                                    <td>{{ $transaction->sous_service_name }}</td>
                                    <td>
                                        <span class="{{status($transaction->{STATUS_TRX_NAME})}}">
                                        {{ $transaction->{STATUS_TRX_NAME} }}
                                        </span>
{{--                                        <details>--}}
{{--                                            <summary>voir message</summary>--}}
{{--                                            <p>--}}
{{--                                                {{($transaction->errorType ? $transaction->errorType->message : '') ?? ''}}--}}
{{--                                            </p>--}}
{{--                                        </details>--}}
                                    </td>
                                    <td>
                                        {{ $transaction->created_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <div class="dropdown-divider"></div>
                                                @if(retroTransaction($transaction))
                                                <a class="dropdown-item waves-light waves-effect" href="/partner/transaction/retro/{{$transaction->id}}">Retro transaction</a>
                                                @endif
                                                <a class="dropdown-item waves-light waves-effect" href="/partner/claim/create?trx={{base64_encode($transaction->id)}}">Reclamation</a>
                                                @if(checkRefundable($transaction)  )
                                                    <a style="cursor: pointer" class="dropdown-item waves-light waves-effect" onclick='refund("{{base64_encode($transaction->id)}}")' >Rembourser la transaction</a>
                                                @endif
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
            <div style="float: right">
                {{ $transactions->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#sous_services_id').select2();
            $('#statut').select2();
        });

       function refund(id){
            if(confirm('??tes-vous s??r de vouloir rembourser ?')){
            window.location.href = "/partner/transaction/reFund/" + id;
           }
        }

    </script>
@endsection

@section('css')
@endsection


