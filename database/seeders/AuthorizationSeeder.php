<?php

namespace Database\Seeders;

use App\Models\Authorization\PartnersActions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions=[
            array('name'=>'Dashboard','code'=>action_dashboard()),
            array('name'=>'Transactions','code'=>action_transaction()),
            array('name'=>'Versement','code'=>action_versement()),
            array('name'=>'Mouvements compte','code'=>action_mvm_compte()),
            array('name'=>'Réclamation','code'=>action_claim()),
            array('name'=>'Services','code'=>action_service()),
            array('name'=>'Clefs APIs','code'=>action_apikey()),
            array('name'=>'Utilisateur','code'=>action_user()),
            array('name'=>'Roles','code'=>action_role()),
            array('name'=>'Remboursement/Annulation','code'=>action_refund()),
            array('name'=>'Retro transaction','code'=>action_retro_trx()),
        ];

        collect($actions)->
            map(function ($action){
            $actionDb = PartnersActions::firstOrCreate(
                ['code' => $action['code']],
                $action
            );

            if (!$actionDb->wasRecentlyCreated) {
                $actionDb->update($action);
            }
        });
    }
}
