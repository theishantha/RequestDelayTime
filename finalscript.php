<?php

// error hidding
error_reporting(0);
ini_set('display_errors', 0);

                        // Db Con
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "selfcareapp";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

    // open for reading file
    $handle = @fopen("nbapi.log", "r");

        if($handle){
            // get line from the file
            while(($buffer = fgets($handle, 4096)) !== false ){
                
                // var_dump ($buffer);
                $array1 = explode("|", $buffer);
                // var_dump ($array1);

                // capture REQUEST in here
                if($array1[4] == "REQUEST"){
                    
                    // json decording 
                    $json_array = json_decode($array1[5], true);
                    // var_dump($json_array);
                    
                    // variable dec
                    $operation = $json_array["operation"];
                    $phonenumber = $json_array["msisdn"];
                    // var_dump($operation, $phonenumber);

                    // sql query for insert query
                    $sql = "INSERT INTO reqdealy (dateandtime, userid, transid, operation_type, phonenumber, json_string)
                                VALUES ('$array1[0]', '$array1[2]', '$array1[3]', '$operation', '$phonenumber', '$array1[5]')";
                    // con init            
                    mysqli_query($conn, $sql);

                    }else{
                    //    existes query capture
                        $sql1 = "SELECT * FROM `reqdealy` WHERE `transid` = '$array1[3]'";

                        

                        $result = mysqli_query($conn, $sql1);
                        // var_dump ($result);

                        if($row = mysqli_fetch_assoc($result)){
                            $reqtime = $row['dateandtime'];
                            // var_dump($reqtime);
                            $restime = $array1[0];
                            // var_dump($restime);
                            
                            // timestamp diff calculating
                            function timestampdiff($reqtime, $restime){
                                $datetime1 = new DateTime("@$reqtime");
                                $datetime2 = new DateTime("@$restime");
                                $interval = $datetime1->diff($datetime2);
                                return $interval->format('%Ss');
                            }

                            $delaytime = & timestampdiff($reqtime, $restime);
                            // var_dump($delaytime); 

                            // timestamp diff updated 
                            $sql2 = "UPDATE reqdealy SET requestdelay = '$delaytime' WHERE  transid = '$array1[3]'";

                            mysqli_query($conn, $sql2);
                

                        }

                    }


            }



        // exit; 
        }


?>