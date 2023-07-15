<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['option']) && isset($_POST['weight'])) {
        
        $option = $_POST['option'];
        $weight = $_POST['weight'];
        $total = 0;

        $options = array(
            "python" => 5.0,
            "customtkinter" => 3.0,
            "widgets" => 2.0,
            "options" => 4.0,
            "menu" => 6.0,
            "combobox" => 7.0,
            "dropdown" => 8.0,
            "search" => 9.0
        );

        if (array_key_exists($option, $options)) {
            $total = $options[$option] * $weight;
        } else {
            echo "Invalid option.";
            die();
        }

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "Mill";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        } else {
            $Insert = "INSERT INTO data(Item_name, Date, Time, Weight, Total) values(?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Insert);
            $stmt->bind_param("ssssi", $option, date("Y-m-d"), date("H:i:s"), $weight, $total);
            if ($stmt->execute()) {
                echo "New record inserted successfully.";
            } else {
                echo $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Option and weight are required.";
        die();
    }
} else {
    echo "Invalid request.";
    die();
}
?>
