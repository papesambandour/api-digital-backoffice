@section('title')
    {{title( 'VERSEMENT' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Authorization\PartnersUsers[] $users ;
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
                            <h4>Mes utilisateurs </h4>
                            <span>Donne la liste de toutes les utilisateurs. Avec une option de creation et de modification des utilisateurs </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <a href="/partner/user/create" type="button" class="primary-api-digital btn btn-primary btn-outline-primary btn-block " >
                        <i  title="Ajouter un clef" class="ti-plus " ></i>
                        <span style=""> Ajouter </span>
                    </a>
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
                                <label class="col-sm-1 col-form-label">Début</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_start}}" name="date_start" id="date_start" type="date"
                                           class="form-control form-control-normal" placeholder="Date de début">
                                </div>
                                {{--                 DATE START                --}}
                                <label class="col-sm-1 col-form-label">Fin</label>
                                <div class="col-sm-2">
                                    <input value="{{$date_end}}" name="date_end" id="date_end" type="date"
                                           class="form-control form-control-normal" placeholder="Date de fin">
                                </div>
                                <div class="col-sm-2">
                                    <input value="{{$q}}" name="q" id="q" type="text"
                                           class="form-control form-control-normal" placeholder="Nom, prénom, Email">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Rechercher
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button onclick="window.location.href='/partner/user'" type="button"
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
                                <th>Prénom</th>
                                <th>Nom </th>
                                <th>Email </th>
                                <th>Télephone </th>
                                <th>Role </th>
                                <th>Status </th>
                                <th>Date</th>
                                <th>Actons</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td> <span class="currency"> {{ $user->first_name }} </span> </td>
                                    <td> <span class="currency"> {{ $user->last_name }} </span> </td>
                                    <td> <span class="currency"> {{ $user->email }} </span> </td>
                                    <td> <span class="currency"> {{ $user->phone }} </span> </td>
                                    <td> <span class="currency"> {{ $user->partnerRole->name }} </span> </td>
                                    <td> <span class="statut-success">{{$user->state}} </span> </td>
                                    <td>
                                        {{ $user->created_at }}
                                    </td>
                                    <td>
                                        <a href="/partner/user/{{$user->id}}/edit">
                                            <i class="icofont icofont-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="float: right">
                {{ $users->links('pagination::bootstrap-4') }}
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
