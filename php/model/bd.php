<?php

    function connect_confins() {
        
        $mysqli = new mysqli("localhost:3306","root",secretReader(),"confins");
        // $mysqli = new mysqli("localhost:3307","root","","confins");
        
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
        return $mysqli; 
    }

    function secretReader() {
        //Uns coment�rios pra bugar a cabe�a, eu acho
        //Ta melhor que o resto do c�digo kk 
        //Puxa os contu�dos de algum lugar que ninigu�m conhece
        $file = file_get_contents("../../bibliotecas/js/secrets.js");
        //Quebra o arquivo em v�rios pedacinhas
        $broke = str_split($file);
        //cria ums vari�veis
        $bsnt = "";
        $pass = "";
        $indexes = [17, 43455, 75, 5986];

        //Faz umas loucuras 
        foreach($indexes as $value) {
            //Add pr�x letra
            $pass .= $broke[$value];
        }

        //Retorna n sei oq
        return $$pass;
    }
    
?>