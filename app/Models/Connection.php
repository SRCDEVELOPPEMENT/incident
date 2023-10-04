<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Redirect;
use Exception;

class Connection extends Model
{
    public function connect(){
        $conn = NULL;
        try {
            
            $serverName = "DEFFO-ARMEL\MSSQL2";
            $uid = "sa";   
            $pwd = "Password01*";
            $databaseName = "incident";
            $connectionInfo = array( "UID"=>$uid,
                                     "PWD"=>$pwd,
                                     "Database"=>$databaseName,
                                     "Encrypt"=>true,
                                     "TrustServerCertificate"=>true); 
            $conn = sqlsrv_connect($serverName, $connectionInfo);
    
        } catch (Exception $ex) {
            toastr()->error($ex->getMessage(), 'ERREUR');
            Redirect::back();
        }

        return $conn;
    }
}
