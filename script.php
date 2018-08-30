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



            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "selfcareapp";

          // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO MyGuests (firstname, lastname, email)
            VALUES ('John', 'Doe', 'john@example.com')";

            if ($conn->query($sql) === true) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        



        }

        exit;

    }
    

  


}
?>