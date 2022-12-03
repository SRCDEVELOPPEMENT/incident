<?php
        if(isset($_POST['sumbit_files'])){

            $target_dir = "upload/";

            for ($i=0; $i < count($_FILES["file"]["name"]); $i++) { 

                $file = $_FILES["file"]['name'][$i];
                $tmp = $_FILES["file"]["tmp_name"][$i];

                $target_file = $target_dir . basename($file);
                
                if (move_uploaded_file($tmp, $target_file)) {

                        $id_tache = intval($_POST['id']);
                        $numero = $_POST['numero'];
                        $date = date("Y-m-d");

                        $serverName = "localhost";
                        $uid = "sa";
                        $pwd = "dev@123";
                        $databaseName = "incident"; 
                        $connectionInfo = array( "UID"=>$uid,                            
                                                        "PWD"=>$pwd,                            
                                                        "Database"=>$databaseName, 
                                                        "Encrypt"=>true, 
                                                        "TrustServerCertificate"=>true); 
                        $conn = sqlsrv_connect($serverName, $connectionInfo);
                        $Query = "INSERT INTO dbo.fichiers(filename, tache_id, created_at) VALUES(?, ?, ?)";
                        $params = array($target_file, $id_tache, $date);
                        $stmt = sqlsrv_query($conn, $Query, $params);
                        if ($stmt)
                        {
                            header("Location: listedTask?number=$numero");
                        }else{
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
            }
        }

        if(isset($_POST['submit_download'])){

            $idTask = $_POST['id'];
            $number = $_POST['numero_down'];
            $idFile = $_POST['grant'];

            $serverName = "localhost"; 
            $uid = "sa";   
            $pwd = "dev@123";  
            $databaseName = "incident"; 
            $connectionInfo = array( "UID"=>$uid,                            
                                            "PWD"=>$pwd,                            
                                            "Database"=>$databaseName, 
                                            "Encrypt"=>true, 
                                            "TrustServerCertificate"=>true); 
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            $Query = "SELECT filename FROM dbo.fichiers
                      WHERE id = ? AND tache_id= ?";

            $parameters = array($idFile, $idTask);

            $tab_files = array();
            
            $stmt = sqlsrv_query( $conn, $Query, $parameters);
            if ($stmt)
            {
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
                {
                    $url = $row[0];
                    array_push($tab_files, $url);
                }

                if(count($tab_files) > 0){
                    for ($i=0; $i < count($tab_files); $i++) {
                        $filename = $tab_files[$i];
                        
                        if(file_exists($filename)){
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                            header('Content-Length: ' . filesize($filename));
                            header('Pragma: public');
        
                            flush();
                            readfile($filename, true);
                        }
                    }
                    //header("Location: listedTask?number=$number");
                }
            }else{
                //die( print_r( sqlsrv_errors(), true));
            }
        }
    ?>