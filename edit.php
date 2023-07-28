<?php
function editCustomer($line, $newData) {
    $data = file("customers.txt");
    $output = array();
    foreach ($data as $customerData) {
        if (trim($customerData) !== trim($line)) {
            $output[] = $customerData;
        }
    }
    $output[] = $newData;
    file_put_contents("customers.txt", implode("", $output));
}

function getCustomerData($line) {
    $customerData = explode(",", urldecode($line));
    // Extract customer data and return as an array
    return array(
        'first_name' => $customerData[0],
        'last_name' => $customerData[1],
        'address' => $customerData[2],
        'country' => $customerData[3],
        'gender' => $customerData[4],
        'skills' => $customerData[5],
        'username' => $customerData[6],
        'password' => $customerData[7], // Note: You may want to handle password update differently
        'department' => $customerData[8]
    );
}

// Check if in edit mode or form submission mode
$editMode = false;
$customerData = array();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['line'])) {
    // Edit mode: Retrieve customer data and pre-fill the form fields for editing
    $editMode = true;
    $customerData = getCustomerData($_GET['line']);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Form submission mode: Handle form data and save changes
    if (isset($_POST['original_line'])) {
        $lineToEdit = urldecode($_POST['original_line']);
        $newData = implode(",", array(
            $_POST["first_name"],
            $_POST["last_name"],
            $_POST["address"],
            $_POST["country"],
            $_POST["gender"],
            isset($_POST["skills"]) ? implode(", ", $_POST["skills"]) : "",
            $_POST["username"],
            $_POST["password"], // Note: You may want to handle password update differently
            $_POST["department"]
        ));
        editCustomer($lineToEdit, $newData);
        header("Location: display_customers.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $editMode ? "Edit Customer" : "Add Customer"; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h2><?php echo $editMode ? "Edit Customer" : "Add Customer"; ?></h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required value="<?php echo $editMode ? $customerData['first_name'] : ''; ?>">
        <br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required value="<?php echo $editMode ? $customerData['last_name'] : ''; ?>">
        <br><br>

        <label for="address">Address:</label>
        <textarea name="address" rows="4" cols="50" required><?php echo $editMode ? $customerData['address'] : ''; ?></textarea>
        <br><br>

        <label for="country">Country:</label>
        <select name="country" required>
            <option value="">Select a Country</option>
            <option value="USA" <?php echo ($editMode && $customerData['country'] === 'USA') ? 'selected' : ''; ?>>USA</option>
            <option value="Canada" <?php echo ($editMode && $customerData['country'] === 'Canada') ? 'selected' : ''; ?>>Canada</option>
            <!-- Add more country options as needed -->
        </select>
        <br><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="male" <?php echo ($editMode && $customerData['gender'] === 'male') ? 'checked' : ''; ?> required>Male
        <input type="radio" name="gender" value="female" <?php echo ($editMode && $customerData['gender'] === 'female') ? 'checked' : ''; ?> required>Female
        <br><br>

        <label>Skills:</label>
        <input type="checkbox" name="skills[]" value="PHP" <?php echo ($editMode && strpos($customerData['skills'], 'PHP') !== false) ? 'checked' : ''; ?>>PHP
        <input type="checkbox" name="skills[]" value="MySQL" <?php echo ($editMode && strpos($customerData['skills'], 'MySQL') !== false) ? 'checked' : ''; ?>>MySQL
        <input type="checkbox" name="skills[]" value="JS" <?php echo ($editMode && strpos($customerData['skills'], 'JS') !== false) ? 'checked' : ''; ?>>JS
        <input type="checkbox" name="skills[]" value="postgreeSQL" <?php echo ($editMode && strpos($customerData['skills'], 'postgreeSQL') !== false) ? 'checked' : ''; ?>>PostgreSQL
        <br><br>

        <label for="username">Username:</label>
        <input type="text" name="username" required value="<?php echo $editMode ? $customerData['username'] : ''; ?>">
        <br><br>

        <label for="department">Department (open source):</label>
        <input type="text" name="department" required value="<?php echo $editMode ? $customerData['department'] : ''; ?>">
        <br><br>

        <?php if ($editMode) : ?>
            <input type="hidden" name="original_line" value="<?php echo urlencode($_GET['line']); ?>">
            <input type="submit" name="submit" value="Save Changes">
            <a href="display_customers.php">Cancel</a>
        <?php else : ?>
            <input type="submit" name="submit" value="Add Customer">
            <a href="display_customers.php">Cancel</a>
        <?php endif; ?>
    </form>
</body>
</html>
