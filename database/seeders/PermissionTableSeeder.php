<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'creer-role',
            'lister-role',
            'editer-role',
            'supprimer-role',
            'voir-role',
            'lister-region',
            'creer-region',
            'editer-region',
            'supprimer-region',
            'voir-region',
            'creer-site',
            'lister-site',
            'editer-site',
            'supprimer-site',
            'voir-site',
            'creer-utilisateur',
            'lister-utilisateur',
            'editer-utilisateur',
            'supprimer-utilisateur',
            'voir-utilisateur',
            'creer-statut',
            'lister-statut',
            'editer-statut',
            'supprimer-statut',
            'voir-statut',
            'creer-vehicule',
            'lister-vehicule',
            'editer-vehicule',
            'supprimer-vehicule',
            'voir-vehicule',
            'creer-poste',
            'lister-poste',
            'editer-poste',
            'supprimer-poste',
            'voir-poste',
            'creer-permission',
            'lister-permission',
            'editer-permission',
            'supprimer-permission',
            'voir-permission',

        ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
