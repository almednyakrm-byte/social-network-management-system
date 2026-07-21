**create_المستخدمين.php**

<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once '../config/db.php';

// Check if form has been submitted
if (isset($_POST['submit'])) {
    // Validate form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = 'Please fill in all fields';
    } else {
        // Insert new user into database
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $password, $role);
        $result = $stmt->execute();

        if ($result) {
            // Redirect back to list page
            header('Location: list_المستخدمين.php');
            exit;
        } else {
            $error = 'Failed to create user';
        }
    }
}

// Include header
require_once '../includes/header.php';

?>

<!-- Create user form -->
<div class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-slate-900 mb-4">Create User</h2>
    <form id="create-user-form" method="post">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-900">Name:</label>
            <input type="text" id="name" name="name" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 border border-slate-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="John Doe">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-slate-900">Email:</label>
            <input type="email" id="email" name="email" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 border border-slate-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="john.doe@example.com">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-slate-900">Password:</label>
            <input type="password" id="password" name="password" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 border border-slate-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Password">
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-slate-900">Role:</label>
            <select id="role" name="role" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 border border-slate-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="moderator">Moderator</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" id="submit-btn" class="w-full py-2 px-4 text-sm font-medium text-white bg-indigo-500 rounded-md hover:bg-indigo-700 focus:ring-indigo-500 focus:border-indigo-500">Create User</button>
    </form>
    <?php if (isset($error)) : ?>
        <p class="text-red-500 mt-2"><?= $error ?></p>
    <?php endif; ?>
</div>

<!-- Include footer -->
<?php require_once '../includes/footer.php'; ?>


**create_المستخدمين.js**
javascript
// Get form element
const form = document.getElementById('create-user-form');

// Add event listener to form submission
form.addEventListener('submit', (e) => {
    e.preventDefault();

    // Get form data
    const formData = new FormData(form);

    // Send AJAX request to backend
    fetch('../backend/المستخدمين.php', {
        method: 'POST',
        body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            // Redirect back to list page
            window.location.href = 'list_المستخدمين.php';
        } else {
            // Display error message
            const errorElement = document.querySelector('.text-red-500');
            errorElement.textContent = data.error;
        }
    })
    .catch((error) => console.error(error));
});


**../backend/المستخدمين.php**

<?php
// Include database connection
require_once '../config/db.php';

// Check if form data has been sent
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    // Validate form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['success' => false, 'error' => 'Please fill in all fields']);
    } else {
        // Insert new user into database
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $password, $role);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create user']);
        }
    }
}