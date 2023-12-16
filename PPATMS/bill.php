<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #87CEEB;
            margin: 0;
        }

        .wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Print button style */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <?php
            session_start();
            require_once('mysqli_connect.php');

            $cust = $_SESSION['cust'];
            $source = $_SESSION['source'];
            $destination = $_SESSION['destination'];
        

            $fare = 50; // Initialize $fare
            $max = 50;  // Initialize $max

            // Get fare based on source and destination
            //$sql = "SELECT fare FROM chart WHERE source = '$source' AND destination = '$destination'";
            $sql = "SELECT fare FROM chart WHERE source = '$source' AND destination = '$destination'";

            $res = mysqli_query($dbc, $sql);
            
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
                $fare = $row['fare'];
            }
            
            // Apply additional charge if the feature is AC
            if ($_SESSION['feature'] == 'AC') {
                $fare = $fare * 1.2;
            }
           
            // Get vehicle capacity and adjust fare accordingly
            $sql = "SELECT * FROM customer WHERE custid = '$cust'";
            
            if ($result = mysqli_query($dbc, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>bill</th>";
                    echo "<th>name</th>";
                    echo "<th>source</th>";
                    echo "<th>destination</th>";
                    echo "<th>vehicle</th>";
                    echo "<th>total fare</th>";

                    echo "</tr>";

                    while ($row = mysqli_fetch_array($result)) {
                        $a1 = $row['vehicle'];

                        // Get max capacity of the vehicle
                        $sql1 = "SELECT maxcap FROM vehicle WHERE numplate = '$a1'";
                        $res = mysqli_query($dbc, $sql1);

                        if (mysqli_num_rows($res) > 0) {
                            $row1 = mysqli_fetch_array($res);
                            $max = $row1['maxcap'];
                        }

                        // Apply additional charge based on vehicle capacity
                        if ($max > 3) {
                            $fare = $fare * 1.2;
                        }

                        echo "<tr>";
                        echo "<td>" . $row['custid'] . "</td>"; // Change to $row['billid']
                        echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                        echo "<td>" . $row['source'] . "</td>";
                        echo "<td>" . $row['destination'] . "</td>";
                        echo "<td>" . $row['vehicle'] . "</td>";
                        echo "<td>" . $fare . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else {
                    echo "No records matching your query were found.";
                }
            } else {
                echo "ERROR: Could not execute $sql. " . mysqli_error($dbc);
            }

            ?>

            <!-- Print button -->
            <button onclick="printBill()">Print</button>
        </div>
    </div>

    <script>
        function printBill() {
            window.print();
        }
    </script>
</body>
</html>