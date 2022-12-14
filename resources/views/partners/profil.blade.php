@section('title')
    {{title( 'Modification Utilisateur' )}}
@endsection

@extends('layouts.main')
<?php
/**
 * @var \App\Models\Users[] $user ;
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
                            <h4>Modification Nouveau Utilisateur</h4>
                            <span>Donne la possibility de Modifier un utilisateur   </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body row">
            <!-- Contextual classes table starts -->
           <div class="col-6">

               <div class="card">
                   <div class="card-header">
                       <div class="card-block">
                           <form method="POST" action="/partner/account" onsubmit="document.getElementById('submit_users').setAttribute('disabled', 'disabled')">
                               <div class="form-group row">
                                   <h3>Modification information personnel</h3>
                               </div>
                               @csrf
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="name" class="col-sm-6 col-form-label">Pr??nom</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{$user->name}}" name="name" id="name" type="text"
                                              class="form-control form-control-normal" placeholder="Nom">
                                       @error('name')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #######################################################FILED ############################### --}}


                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="phone" class="col-sm-6 col-form-label">Telephone</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{$user->phone}}" name="phone" id="phone" type="tel"
                                              class="form-control form-control-normal" placeholder="T??l??phone">
                                       @error('phone')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="allow_id" class="col-sm-6 col-form-label">
                                       IP autoris??s
                                       <span style="color: red; font-size: 10px">
                                        les IP sont s??par??s par point virgule ";"
                                    </span>
                                   </label>
                                   <div class="col-sm-6">
                                       <textarea
                                           name="allow_id" id="allow_id"
                                           class="form-control form-control-normal" placeholder="IP autoris??s">{{$user->allow_id}}</textarea>
                                       @error('allow_id')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>

                             {{--  <div class="form-group row">
                                   <label class="col-sm-6 col-form-label">Pays</label>
                                   <div class="col-sm-6">
                                       <select  required  name="countries_id" id="countries_id" class="">
                                           <option value="" selected> ---S??lectionner un Pays ---</option>
                                           @foreach(countries() as $country)
                                               <option @if($user->countries_id == $country->id  ) selected @endif value="{{$country->id}}"> {{$country->name}} </option>
                                           @endforeach

                                       </select>
                                   </div>
                               </div>--}}




                                  <div class="form-group row" style="margin-top: 100px">
                                      <div class="col-sm-6">
                                          <button id="submit_users"  type="submit"
                                                  class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                                  class="icofont icofont-save"></i>Enregistrer
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
              <div class="col-6">
                  <div class="card">
                      <div class="card-header">
                          <div class="card-block">
                              <form method="POST" action="/partner/password" onsubmit="document.getElementById('password_submit').setAttribute('disabled', 'disabled')">
                                  <div class="form-group row">
                                      <h3>Modification mot de passe</h3>
                                  </div>
                                  @csrf
                                  {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="password_old" class="col-sm-6 col-form-label">Mot de passe actuel</label>
                                   <div class="col-sm-6">
                                       <input required   name="password_old" id="password_old" type="password"
                                              class="form-control form-control-normal" placeholder="Mot de passe actuel">
                                       @error('password_old')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="password" class="col-sm-6 col-form-label">Nouveau Mot de passe</label>
                                   <div class="col-sm-6">
                                       <input required   name="password" id="password" type="password"
                                              class="form-control form-control-normal" placeholder="Nouveau Mot de passe">
                                       @error('password')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="confirm_password" class="col-sm-6 col-form-label">Confirmation Mot de passe</label>
                                   <div class="col-sm-6">
                                       <input required   name="confirm_password" id="confirm_password" type="password"
                                              class="form-control form-control-normal" placeholder="Confirmation Mot de passe">
                                       @error('confirm_password')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}

                               <div class="form-group row" style="margin-top: 100px">
                                   <div class="col-sm-6">
                                       <button id="password_submit"  type="submit"
                                               class="primary-api-digital btn btn-primary btn-outline-primary btn-block"><i
                                               class="icofont icofont-save"></i>Modifier le mot de passe
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
        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')
    <script>
        $("#countries_id").select2()
    </script>
@endsection

@section('css')
@endsection
