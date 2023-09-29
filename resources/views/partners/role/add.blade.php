@section('title')
    {{title( 'Modification Utilisateur' )}}
@endsection

@extends('layouts.main')
<?php

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
                            <h4>Ajout/Modification role</h4>
                            <span>Donne la possibility de Modifier un role   </span>
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
                           <form id="frmRole" method="POST" action="{{$role ? '/partner/role/'.$role->id  :'/partner/role'}}" onsubmit="document.getElementById('submit_users').setAttribute('disabled', 'disabled')">
                               <div class="form-group row">
                                   <h3>Informations du role</h3>
                               </div>
                               @if($role)
                                   @method('put')
                               @endif

                               @csrf
                               {{-- #############################################FILED ############################## --}}
                               <div class="form-group row">
                                   <label for="name" class="col-sm-6 col-form-label">Libellé</label>
                                   <div class="col-sm-6">
                                       <input required  value="{{old('name',@$role->name)}}" name="name" id="name" type="text"
                                              class="form-control form-control-normal" placeholder="Libellé">
                                       @error('name')
                                       <div  class="invalid-feedback ">
                                           {{ $message }}
                                       </div>
                                       @enderror
                                   </div>


                               </div>
                               <h5 class="mt-2 mb-5">Définir les actions du role</h5>

                               <div class="form-group row">

                                   @foreach($partnersActions as $action)

                                       <div class="col-sm-4">

                                           <label>
                                               <input @if(has($action->code,$role->id)) checked @endif type="checkbox" name="actions[]" value="{{$action->id}}">
                                               {{$action->name}}
                                           </label>
                                       </div>
                                   @endforeach
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
    <script>
        @if(!$role)
          document.getElementById('frmRole').reset();
        @endif
    </script>

@endsection

@section('css')
@endsection
