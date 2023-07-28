<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .delete-btn, .edit-btn {
            padding: 6px 10px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .delete-btn:hover, .edit-btn:hover {
            background-color: #c82333;
        }
    </style>    
</head>
<body>
    <h2>Customer List</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Country</th>
            <th>Gender</th>
            <th>Skills</th>
            <th>Username</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        <?php
        if (file_exists("customers.txt")) {
            $lines = file("customers.txt");
            foreach ($lines as $line) {
                $customer = explode(",", $line);
                list($first_name, $last_name, $address, $country, $gender, $skills, $username, $password, $department) = $customer;
                echo "<tr>";
                echo "<td>$first_name</td>";
                echo "<td>$last_name</td>";
                echo "<td>$address</td>";
                echo "<td>$country</td>";
                echo "<td>$gender</td>";
                echo "<td>$skills</td>";
                echo "<td>$username</td>";
                echo "<td>$department</td>";
                echo "<td><a href='delete.php?line=" . urlencode($line) . "' style='color: red;'>Delete</a> | <a href='edit.php?line=" . urlencode($line) . "' style='color: orange;'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No customer data found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
