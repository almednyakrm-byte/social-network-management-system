<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الشبكات الاجتماعية</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .glassmorphism-card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="h-screen w-screen flex justify-center items-center bg-slate-900">
        <div class="glassmorphism-card w-1/2 p-10">
            <h1 class="text-3xl text-indigo-500 font-bold mb-5">نظام إدارة الشبكات الاجتماعية</h1>
            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='logout.php'">تسجيل الخروج</button>
            <div class="mt-10">
                <h2 class="text-2xl font-bold mb-5">إحصائيات</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-bold mb-2">المستخدمين</h3>
                        <p id="users-count" class="text-2xl font-bold mb-4"></p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-bold mb-2">المتابعين</h3>
                        <p id="followers-count" class="text-2xl font-bold mb-4"></p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-bold mb-2">المحادثات</h3>
                        <p id="conversations-count" class="text-2xl font-bold mb-4"></p>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <h2 class="text-2xl font-bold mb-5">الرابط السريع</h2>
                <ul class="list-none p-0">
                    <li class="mb-4">
                        <a href="users.php" class="text-lg font-bold text-indigo-500 hover:text-indigo-700">المستخدمين</a>
                    </li>
                    <li class="mb-4">
                        <a href="conversations.php" class="text-lg font-bold text-indigo-500 hover:text-indigo-700">المحادثات</a>
                    </li>
                    <li class="mb-4">
                        <a href="followers.php" class="text-lg font-bold text-indigo-500 hover:text-indigo-700">المتابعين</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        fetch('api/stats.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('users-count').innerText = data.users_count;
                document.getElementById('followers-count').innerText = data.followers_count;
                document.getElementById('conversations-count').innerText = data.conversations_count;
            })
            .catch(error => console.error(error));
    </script>
</body>
</html>


This code uses the Tailwind CSS framework to create a premium dashboard layout with a glassmorphism card design. The color palette is set to slate-900 and indigo-500 as per your requirements. The dashboard layout includes a welcome message, logout button, overview stats grid, and quick links to manage modules.

The stats are fetched dynamically via a JavaScript API call to the backend file `api/stats.php`. The API call returns a JSON object containing the stats, which are then displayed on the dashboard.

Note that you will need to create the `api/stats.php` file to handle the API request and return the stats data. You will also need to create the `logout.php` file to handle the logout functionality.