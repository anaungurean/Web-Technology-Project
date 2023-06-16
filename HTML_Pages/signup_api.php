<?php
// Retrieve the form data from the AJAX request
$email = isset($_POST['email']) ? $_POST['email'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate the form data
if (empty($email) || empty($username) || empty($password)) {
    // Form data is incomplete
    $response = array(
        'success' => false,
        'message' => 'Please fill in all the required fields.'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Create a new PDO instance (replace the database credentials with your own)
$dsn = 'mysql:host=localhost;dbname=hemadatabase;charset=utf8mb4';
$db_user = 'root';
$db_password = '';
try {
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection errors
    $response = array(
        'success' => false,
        'message' => 'Database connection error: ' . $e->getMessage()
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Check if the email and username are unique
if (isEmailUnique($pdo, $email) && isUsernameUnique($pdo, $username)) {
    // Generate a password hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $pdo->prepare('INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$email, $username, $hashedPassword]);

    // Check if the user was inserted successfully
    if ($stmt->rowCount() > 0) {
        // User registration successful
        $response = array(
            'success' => true,
            'message' => 'Registration successful!'
        );
    } else {
        // User registration failed
        $response = array(
            'success' => false,
            'message' => 'Failed to register user.'
        );
    }
} else {
    // User registration failed
    $response = array(
        'success' => false,
        'message' => 'Email or username already exists.'
    );
}

// Send the JSON response back to the AJAX request
header('Content-Type: application/json');
echo json_encode($response);

// Helper functions to check email and username uniqueness
function isEmailUnique($pdo, $email)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetchColumn() == 0;
}

function isUsernameUnique($pdo, $username)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
    $stmt->execute([$username]);
    return $stmt->fetchColumn() == 0;
}
?>
