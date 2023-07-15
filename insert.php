<?php
if (isset($_POST['Done'])) {
    if (isset($_POST['Item_name']) && isset($_POST['Date']) &&
        isset($_POST['Time']) && isset($_POST['Weight']) &&
        isset($_POST['Total'])) {
        
        $Item_name = $_POST['Item_name'];
        $Date = $_POST['Date'];
        $Time = $_POST['Time'];
        $Weight = $_POST['Weight'];
        $Total = $_POST['Total'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "Mill";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Insert = "INSERT INTO data(Item_name, Date, Time, Weight, Total) values(?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Insert);
            $stmt->bind_param("sssii",$Item_name, $Date, $Time, $Weight, $Total);
            if ($stmt->execute()) {
                echo "New record inserted sucessfully.";
            }
            else {
                echo $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>