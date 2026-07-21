<?php
// create_المحادثات.php

// Session validation
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include '../backend/db.php';

// Define module slug
$mod_slug = 'المحادثات';

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محادثة جديدة</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="h-screen bg-slate-900 text-indigo-500">
    <div class="container mx-auto p-4 pt-6 mt-10 bg-slate-800 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4 text-indigo-500">إضافة محادثة جديدة</h1>
        <form id="create-form" class="space-y-4">
            <div class="flex flex-col">
                <label for="title" class="text-lg font-medium text-indigo-500">العنوان</label>
                <input type="text" id="title" name="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="flex flex-col">
                <label for="content" class="text-lg font-medium text-indigo-500">المحتوى</label>
                <textarea id="content" name="content" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <div class="flex flex-col">
                <label for="user_id" class="text-lg font-medium text-indigo-500">المستخدم</label>
                <select id="user_id" name="user_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <?php
                    // Fetch users from database
                    $users = mysqli_query($conn, "SELECT id, name FROM users");
                    while ($user = mysqli_fetch_assoc($users)) {
                        echo '<option value="' . $user['id'] . '">' . $user['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">إضافة</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#create-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../backend/المحادثات.php',
                    data: $(this).serialize(),
                    success: function() {
                        window.location.href = 'list_المحادثات.php';
                    }
                });
            });
        });
    </script>
</body>
</html>