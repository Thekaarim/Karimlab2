<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .confirmation-info {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['first_name']) && isset($_GET['last_name']) && isset($_GET['address']) && isset($_GET['country']) && isset($_GET['gender']) && isset($_GET['skills']) && isset($_GET['username']) && isset($_GET['department'])) {
        $first_name = $_GET['first_name'];
        $last_name = $_GET['last_name'];
        $address = $_GET['address'];
        $country = $_GET['country'];
        $gender = $_GET['gender'];
        $skills = $_GET['skills'];
        $username = $_GET['username'];
        $department = $_GET['department'];
    }
    ?>

    <h2>Thank you, <?php echo ($gender === 'male') ? 'Mr. ' : 'Miss '; echo $first_name . ' ' . $last_name; ?></h2>
    <div class="confirmation-info">
        <p>Please review your information:</p>
        <p><strong>Name:</strong> <?php echo $first_name . ' ' . $last_name; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Your Skills:</strong> <?php echo $skills; ?></p>
        <p><strong>Country:</strong> <?php echo $country; ?></p>
        <p><strong>Username:</strong> <?php echo $username; ?></p>
        <p><strong>Department:</strong> <?php echo $department; ?></p>
    </div>
    <p><a href="display_customers.php">View All Customers</a></p>
</body>
</html>
