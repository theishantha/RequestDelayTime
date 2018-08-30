<?php

// $nbapilog = file('nbapi.log');
// $nb_arr = array($nbapilog);
// // $nbstring = join(" ", $nb_arr);
// print_r($nb_arr);


$handle = @fopen("nbapi.log", "r");

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {

        // list($timeStamp, $ire1, $userName, $transId ,$message , $lastDataSet) = explode("|",$buffer);
        // // echo $message;

        $array1 = explode("|", $buffer);
        // var_dump ($array1);

        if ($array1[4] == 'REQUEST') {
            $json_array = json_decode($array1[5],true);
            // var_dump($json_array);
            // echo $json_array["operation"];

            
        }

        exit;

    }
    

  


}
?>