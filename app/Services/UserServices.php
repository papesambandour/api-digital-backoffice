<?php

namespace App\Services;

use App\Models\Parteners;
use App\Models\Plateforme;
use App\Models\Profils;
use App\Models\Users;
use App\Services\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserServices
{


    public function account(Request $request)
    {
        $user = user();
        $request->validate(Utils::getRuleModel(new Parteners(),$user->id,$request->all()));
        $data= $request->only(['name','email','phone','adress']);//
        $user->update($data);
        return redirect('/partner/profil')->with('success','Infos utilisateur changer avec succès');
    }
    public function password(Request $request)
    {
        $user = user();
        if(!Hash::check($request->get('password_old'),$user->password)){
            return  redirect()->back(302)->with('error',"L'ancien mot de passe n'est est incorrect");
        }
        $validated  =$request->validate([
            'password' =>'required|min:8|same:confirm_password',
            'confirm_password' =>'required|min:8',
            'password_old' =>'required',
        ],$request->all());

        $user->update(['password' => Hash::make($validated['password'])]);
        return redirect('/partner/profil')->with('success','Mot de passe utilisateur a changé avec succès');
    }
}
