<?php

namespace App\Services\Partners\Security;

use App\Models\Authorization\PartnersUsers;
use App\Models\Parteners;
use Illuminate\Support\Facades\Hash;

class LoginPartnerServices
{
    public function login(string $user,string $password): bool
    {
       $partner =  Parteners::where('email', '=', $user)->first();
        /**
         * @var $partnerUser PartnersUsers
         */
       $partnerUser= PartnersUsers::where('email', '=', $user)->first();
       $isPartnerUser=false;
       if(!$partner && $partnerUser){
           $isPartnerUser=true;
       }
       // dd($partner,$partnerUser,$isPartnerUser);


        if(!$isPartnerUser && $partner && Hash::check( $password,$partner->password) ){
            loginUser($partner);
            return true;
        }
        else if($isPartnerUser && $partnerUser && Hash::check( $password,$partnerUser->password) ){
            loginUser($partnerUser->partner,$partnerUser);
            return true;
        }
        else{
            return false;
        }
    }


}
