<?php

                        // Db Con
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "selfcareapp";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

// open for reading file
$handle = @fopen("nbapi.log", "r");

    if ($handle) {
        
        // get line from the file 
        while (($buffer = fgets($handle, 4096)) !== false) {

                
            $array1 = explode("|", $buffer);
            // var_dump ($array1);

        
            if ($array1[4] == 'REQUEST') {
                $json_array = json_decode($array1[5],true);
                // var_dump($json_array);
                // echo $json_array["operation"];
                $operation = $json_array["operation"];
                $phonenumber = $json_array["msisdn"];

                // var_dump($array1);
                    
                        
                        $sql = "INSERT INTO reqdealy (dateandtime, userid, transid, operation_type, phonenumber, json_string)
                        VALUES ('$array1[0]', '$array1[2]', '$array1[3]', '$operation', '$phonenumber', '$array1[5]')";
                        // echo $sql;
                        mysqli_query($conn, $sql);

            
                }else{

                        $restime = $array1[0];

                        $sql1 = "SELECT * FROM `reqdealy` WHERE `transid` = '$array1[3]'";
                        // echo $sql1;
                        $result = mysqli_query($conn, $sql1);
                            
                        //echo mysql_error($result);


                        if($row = mysqli_fetch_assoc($result)){
                            // var_dump($row);
                            $reqtime = $row['dateandtime'];
                            
                            // var_dump($reqtime);
                            $restime = $array1[0];


                            // function timestampdiff($qw, $saw)
                            // {
                            //     $datetime1 = new DateTime("@$qw");
                            //     $datetime2 = new DateTime("@$saw");
                            //     $interval = $datetime1->diff($datetime2);
                            //     return $interval->format('%Hh %Im');
                            // }
                            // echo timestampdiff('1524794340', '1524803100');

                                


                            $json_array = json_decode($array1[5], true);
                            // var_dump($json_array);
                            // echo $json_array["operation"];
                            $operation = $json_array["operation"];
                            $phonenumber = $json_array["msisdn"];
            
                            
                        }    

                        // if($array1[4] = $sql1 ){




                        function timestampdiff($qw, $saw)
                        {
                            $datetime1 = new DateTime("@$qw");
                            $datetime2 = new DateTime("@$saw");
                            $interval = $datetime1->diff($datetime2);
                            return $interval->format('%Hh %Im');
                        }
                        echo timestampdiff('1524794340', '1524803100');



                        }
            }

        // exit; 

        }
    

  



?>