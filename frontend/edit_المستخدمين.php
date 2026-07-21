**edit_المستخدمين.php**

<?php
// Session validation
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Fetch existing record details via GET
$url = '../backend/المستخدمين.php?id=' . $id;
$response = file_get_contents($url);
$data = json_decode($response, true);

// Set page title and meta tags
$page_title = 'تعديل المستخدم';
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto p-4 bg-white rounded-md shadow-md">
        <h2 class="text-lg font-bold text-slate-900 mb-4"><?= $page_title ?></h2>
        <form id="edit-user-form">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700">اسم المستخدم</label>
                <input type="text" id="name" name="name" class="block w-full p-2 mt-1 border border-gray-300 rounded-md" value="<?= $data['name'] ?>">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" class="block w-full p-2 mt-1 border border-gray-300 rounded-md" value="<?= $data['email'] ?>">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700">كلمة المرور</label>
                <input type="password" id="password" name="password" class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">حفظ</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#edit-user-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'PUT',
                    url: '../backend/المستخدمين.php',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = 'list_المستخدمين.php';
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>


**backend/المستخدمين.php**

<?php
// Update existing record
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update record in database
    // Replace with your actual database update code
    $updated = true; // Assume record updated successfully

    if ($updated) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating record']);
    }
}
?>

Note: Replace the `backend/المستخدمين.php` file with your actual backend code to update the user record in the database.