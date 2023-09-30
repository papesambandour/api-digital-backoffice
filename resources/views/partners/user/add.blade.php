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
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="icofont icofont-table bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Ajout Nouveau Utilisateur</h4>
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
        <div class="page-body row justify-content-center">
            <!-- Contextual classes table starts -->
           <div class="col-8">

               <div class="card">
                   <div class="card-header">
                       <div class="card-block">
                           <form method="POST" action="{{$user ? '/partner/user/'.$user->id  :'/partner/user'}}" onsubmit="document.getElementById('submit_users').setAttribute('disabled', 'disabled')">
                               <div class="form-group row">
                                   <h3>Informations de l'utilisateurs</h3>
                               </div>
                               @if($user)
                                   @method('put')
                               @endif

                               @csrf
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="first_name" class="col-sm-6 col-form-label">Prénom</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{old('first_name',@$user->first_name)}}" name="first_name" id="first_name" type="text"
                                              class="form-control form-control-normal" placeholder="Prénom">
                                       @error('first_name')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="last_name" class="col-sm-6 col-form-label">Nom</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{old('last_name',@$user->last_name)}}" name="last_name" id="first_name" type="text"
                                              class="form-control form-control-normal" placeholder="Nom">
                                       @error('last_name')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>
                               {{-- #######################################################FILED ############################### --}}


                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="email" class="col-sm-6 col-form-label">Email</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{old('email',@$user->email)}}" name="email" id="email" type="email"
                                              class="form-control form-control-normal" placeholder="Email">
                                       @error('email')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>

                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="phone" class="col-sm-6 col-form-label">Telephone</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{old('phone',@$user->phone)}}" name="phone" id="phone" type="tel"
                                              class="form-control form-control-normal" placeholder="Téléphone">
                                       @error('phone')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>

                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="parteners_roles_id" class="col-sm-6 col-form-label">Role</label>
                                   <div class="col-sm-6">
                                       <select required  value="{{old('parteners_roles_id',@$user->parteners_roles_id)}}" name="parteners_roles_id" id="parteners_roles_id"
                                               class="form-control form-control-normal" >
                                           <option>---Sélectionner un element---</option>
                                           @foreach($roles as $role)
                                               <option @if(old('parteners_roles_id',@$user->parteners_roles_id) == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                           @endforeach

                                       </select>

                                       @error('parteners_roles_id')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>
                               </div>




                                  <div class="form-group row justify-content-center" style="margin-top: 100px">
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

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->

@endsection

@section('js')

@endsection

@section('css')
@endsection
