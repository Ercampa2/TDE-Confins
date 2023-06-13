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
        //Uns comentários pra bugar a cabeça, eu acho
        //Ta melhor que o resto do código kk 
        //Puxa os contuúdos de algum lugar que niniguém conhece
        $file = file_get_contents("../../bibliotecas/js/secrets.js");
        //Quebra o arquivo em vários pedacinhas
        $broke = str_split($file);
        //cria ums variáveis
        $bsnt = "";
        $pass = "";
        $indexes = [17, 43455, 75, 5986];

        //Faz umas loucuras 
        foreach($indexes as $value) {
            //Add próx letra
            $pass .= $broke[$value];
        }

        //Retorna n sei oq
        return $$pass;
    }
    
?>