@section('title')
    {{title( 'CLEE APIs' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\PartenerComptes[] $apisKeys ;
 */
?>
@section('page')

    <div class="page-wrapper">
        <!-- Page-header start -->
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
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Mes clefs APIs</h4>
                            <span>Donne la liste de toutes les clés APIs du partenaire  </span>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="addKey" style=" float: right" action="/partner/apikey/addkey" method="POST">
                        @csrf
                        <button onclick='addKey("addKey")' type="button" class="primary-api-digital btn btn-primary btn-outline-primary btn-block " >
                            <i  title="Ajouter un clef" class="ti-plus " ></i>
                            <span style=""> Ajouter une clé</span>
                        </button>
                    </form>
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
                    <h5>Filtres</h5>
                    <div class="card-block">
                        <form>
                            <div class="form-group row">
                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Date de début</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de début">
                                </div>
                                {{--                 DATE START                --}}

                                {{--                 DATE START                --}}
                                <label class="col-sm-2 col-form-label">Date de fin</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button onclick="window.location.href='/partner/apikey'" type="button"
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
                                <th># Id</th>
                                <th>Libelle</th>
                                <th>Clef</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apisKeys as $apisKey)
                                <tr>
                                    <th scope="row">
                                        <span style="font-weight: bold;color: #324960;text-decoration: underline">
                                            {{$apisKey->id}}
                                        </span>
                                    </th>
                                    <td class="text-left"> <span class="currency " style="text-align: left !important;"> {{ $apisKey->name }} </span> </td>

                                    <td>
                                        <span class="currency" style="font-size: 25px">
                                               **********************************************
                                        </span>

                                    </td>

                                    <td>
                                        @if($apisKey->state === STATE['ACTIVED'])
                                            <span class="statut-success">ACTIF </span>
                                        @else
                                            <span class="statut-danger">RÉVOQUÉ </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $apisKey->created_at }}
                                    </td>
                                    <td style="width: 200px">
                                        <div class="btn-group dropdown-split-success">

                                            <button style="background: transparent;color: #4fc3a1;border: none;width: 100%;height: 30px" type="button" class="btn btn-success  dropdown-toggle-split waves-effect waves-light icofont icofont-navigation-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <div class="dropdown-divider"></div>


                                                <a  href="#"  class="dropdown-item waves-light waves-effect" onclick='showKey("{{$apisKey->app_key}}","{{$apisKey->name}}")' title="Voir le clef API">
                                                    <i  class="ti-eye " ></i> Voir votre clef API
                                                </a>

                                                <form id="{{$apisKey->id}}" style="display: inline" action="/partner/apikey/regenerateKey/{{$apisKey->id}}" method="POST">
                                                    @csrf
                                                    <a  href="#"  style="padding: 5px 17px;font-size: 14px;" class="dropdown-item waves-light waves-effect" onclick='regenerateAppKey("{{$apisKey->id}}")'  title="Régénérer votre clef API " >
                                                        <i  class="ti-reload " ></i> Régénérer votre clef API
                                                    </a>
                                                </form>

                                                <form id="{{$apisKey->id . '_revok'}}" style="display: inline" action="/partner/apikey/revoqKey/{{$apisKey->id}}" method="POST">
                                                    @csrf
                                                    <a  href="#"  style="padding: 5px 17px;font-size: 14px;" class="dropdown-item waves-light waves-effect" onclick='revoqAppKey("{{$apisKey->id . '_revok'}}")'  title="Régénérer votre clef API " >

                                                        @if($apisKey->state === STATE['ACTIVED'])
                                                            <i  class="ti-close " ></i> Révoquer votre clef API
                                                        @else
                                                            <i  class="ti-check " ></i> Activer votre clef API
                                                        @endif
                                                    </a>
                                                </form>

                                                <form id="{{$apisKey->id . '_raname'}}" style="display: inline" action="/partner/apikey/raname/{{$apisKey->id}}" method="POST">
                                                    @csrf
                                                    <a  href="#"  style="padding: 5px 17px;font-size: 14px;" class="dropdown-item waves-light waves-effect" onclick='renameAppKey("{{$apisKey->id . '_raname'}}", "{{$apisKey->name}}" , "{{$apisKey->id . '_name'}}")'  title="Régénérer votre clef API " >
                                                        <i  class="ti-more-alt " ></i> Renommé votre clef API
                                                    </a>
                                                    <input type="hidden" name="name" id="{{$apisKey->id . '_name'}}">
                                                </form>
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
                {{ $apisKeys->links('pagination::bootstrap-4') }}
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
<script>
    function showKey(appKey,appName) {
        Notiflix
            .Report
            .info(
                appName,
                `<br>${appKey}<br>`,
                'FERMER',
                {
                    svgSize: '42px',
                    messageMaxLength: appKey.length,
                    plainText: true,
                },
            );
    }
    function regenerateAppKey(idForm) {
        let msg='Voulez-vous régénération votre clé API ?';
        Notiflix
            .Confirm
            .show('Régénération clé API ',msg,
                'Oui',
                'Non',
                () => {document.getElementById(idForm).submit()},
                () => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
    function revoqAppKey(idForm) {
        let msg='Voulez-vous révoqué votre clé API ?';
        Notiflix
            .Confirm
            .show('Révoqué votre clé API ',msg,
                'Oui',
                'Non',
                () => {document.getElementById(idForm).submit()},
                () => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
    function renameAppKey(idForm,name,idInput) {
        let msg='Nouveau labelle';
        Notiflix
            .Confirm
            .prompt(
                'Renommer votre clé API ',
                msg,
                name,
                'Appliquer',
                'Annuler',
                (clientAnswer) => {
                    $(`#${idInput}`).val(clientAnswer);
                    document.getElementById(idForm).submit()
                },
                (clientAnswer) => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
    function addKey(idForm) {
        let msg='Voulez-vous ajouter un nouveau clef API ?';
        Notiflix
            .Confirm
            .show('Ajout clé API ',msg,
                'Oui',
                'Non',
                () => {document.getElementById(idForm).submit()},
                () => {console.log('If you say so...');},
                { messageMaxLength: msg.length + 90,},);
    }
</script>
@endsection

@section('css')
@endsection
