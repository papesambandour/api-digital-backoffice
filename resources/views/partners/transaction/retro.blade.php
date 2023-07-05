@section('title')
    {{title( 'RETRO TRANSACTION' )}}
@endsection
<?php
/**
 * @var \App\Models\Transactions $transaction ;
 */
?>
@extends('layouts.main')

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
                            <h4>Retro transaction </h4>
                            <span> </span>
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

                <div class="card-block table-border-style">

                    <form id="formTransaction" onsubmit="event.preventDefault(); handleFormSubmission(event)" action="/partner/transaction/retro/{{$transaction->id}}" method="POST"  class="modal-body col-4">
                        @csrf
                        <div class="form-group row">
                            {{--                 DATE START                --}}
                            <label class="col-sm-12 col-form-label">Numéro : {{$transaction->phone}}</label>
                            <label class="col-sm-12 col-form-label">Montant :  <span class="currency">{{$transaction->amount}} CFA</span> </label>
                            <label class="col-sm-12 col-form-label">Sous Service :  <span class="currency">{{$transaction->sous_service_name}}</span> </label>


                        </div>
                        <div >
                            <div v-if="typeAction === 'retro'" class="form-group row">
                                <label class="col-sm-12 col-form-label">Sous Services</label>
                                <div class="col-sm-12">
                                    <select  required  name="codeService" id="codeService" class="form-control"
                                             placeholder="Sous Services text-center">
                                        <option value="" selected> </option>
                                        @foreach($sousServices as $sousService)
                                        <option value="{{$sousService->code}}"> {{$sousService->name}} </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div v-if="typeAction === 'retro'" class="form-group row">
                                <label class="col-sm-12 col-form-label">Montant</label>
                                <div class="col-sm-12">
                                    <input required placeholder="Montant" name="amount" id="amount" type="number" class="form-control" value="{{$transaction->amount}}">
                                </div>

                            </div>

                            <input type="hidden" name="submitting" value="false">


                            <div class="text-center">
                                <button  class="primary-api-digital btn btn-primary btn-outline-primary "
                                         type="submit" >
                                    <i class="ti-save"></i> Faire la retro transaction
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <!-- Contextual classes table ends -->
    </div>

    <!-- Page-body end -->


    <script>
        function handleFormSubmission(event) {
            event.preventDefault(); // Prevent the default form submission

            var form = document.getElementById("formTransaction");
            var submittingInput = form.querySelector("input[name='submitting']");

            // Check if the form is already being submitted
            if (submittingInput.value === "true") {
                alert("Traitement Déja en cours, veuillez patienter...")

                return false; // Abort form submission
            }

            window.showLoader("Traitement en cours, veuillez patienter...")

            submittingInput.value = "true";


            form.submit();
        }


    </script>

@endsection

@section('js')

@endsection

@section('css')
@endsection
