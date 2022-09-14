@section('title')
    {{title( 'SERVICES' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Parteners[] $partners ;
 */
?>
@section('page')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                  <li>{{Session::get('error')}}</li>
            </ul>
        </div>
    @endif

    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Ajout Nouveau Partenaires</h4>
                            <span>Donne la possibility d'ajouter un partenaire   </span>
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
                    <div class="card-block">
                        <form method="POST" action="/partner/claim" onsubmit="document.getElementById('submit_claim').setAttribute('disabled', 'disabled')">
                            @csrf
                            <input type="hidden" value="{{$transaction_id}}" name="transaction_id" id="transaction_id">
                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="subject" class="col-sm-3 col-form-label">Sujet</label>
                                <div class="col-sm-3">
                                    <input required  value="{{old('subject')}}" name="subject" id="subject" type="text"
                                           class="form-control form-control-normal" placeholder="Sujet">
                                    @error('subject')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                  {{-- #######################################################FILED ############################### --}}


                  {{-- #############################################FILED ############################## --}}
                            <div class="form-group row">
                                <label for="message" class="col-sm-3 col-form-label">Message</label>
                                <div class="col-sm-3">
                                    <textarea rows="10" required  name="message" id="message"
                                              class="form-control form-control-normal" placeholder="Message">{{old('message')}}</textarea>
                                    @error('message')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                  {{-- #############################################FILED ############################## --}}
                           {{-- <div class="form-group row">
                                <label for="transaction_id" class="col-sm-3 col-form-label">Message</label>
                                <div class="col-sm-3">
                                    <select  required  name="transaction_id" id="transaction_id"
                                              class="form-control form-control-normal" >

                                       @foreach($transactions as $transaction)
                                            <option value="{{$transaction->id}}">{{$transaction->id}}</option>
                                       @endforeach
                                    </select>
                                    @error('message')
                                    <div  class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>--}}
                            {{-- #############################################FILED ############################## --}}

                            <div class="form-group row" style="margin-top: 100px">
                                <div class="col-sm-3">
                                    <button id="submit_claim"  type="submit"
                                            class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                            class="icofont icofont-search"></i>Enregistrer
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="window.location.href='/partners'" type="button"
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
