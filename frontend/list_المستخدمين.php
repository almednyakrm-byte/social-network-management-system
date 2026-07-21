**list_المستخدمين.php**

<?php
// Session validation
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
    <title>المستخدمين</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
        }
        .header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 1rem;
            text-align: center;
        }
        .header a {
            color: #ffffff;
            text-decoration: none;
        }
        .header a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }
        .table th {
            background-color: #1f2937;
            color: #ffffff;
        }
        .search-bar {
            width: 50%;
            padding: 1rem;
            font-size: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
        }
        .search-bar:focus {
            outline: none;
            border-color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">الرئيسية</a>
        <span class="text-lg font-bold">المستخدمين</span>
        <span class="float-right">
            <a href="profile.php"><?= $_SESSION['username']; ?></a> |
            <a href="logout.php">تسجيل الخروج</a>
        </span>
    </div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">قائمة المستخدمين</h1>
        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_المستخدمين.php'">إضافة مستخدم جديد</button>
        <div class="flex justify-center mb-4">
            <input type="search" class="search-bar" id="search-input" placeholder="بحث...">
            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="searchRecords()">بحث</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>اسم المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>حذف</th>
                    <th>تعديل</th>
                </tr>
            </thead>
            <tbody id="records-table">
                <!-- Records will be loaded here -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch API to load records
        async function loadRecords() {
            const response = await fetch('../backend/المستخدمين.php');
            const data = await response.json();
            const recordsTable = document.getElementById('records-table');
            recordsTable.innerHTML = '';
            data.forEach((record) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${record.username}</td>
                    <td>${record.email}</td>
                    <td><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteRecord(${record.id})">حذف</button></td>
                    <td><a href="edit_المستخدمين.php?id=${record.id}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">تعديل</a></td>
                `;
                recordsTable.appendChild(row);
            });
        }

        // Search records
        function searchRecords() {
            const searchInput = document.getElementById('search-input').value;
            fetch('../backend/المستخدمين.php?search=' + searchInput)
                .then(response => response.json())
                .then(data => {
                    const recordsTable = document.getElementById('records-table');
                    recordsTable.innerHTML = '';
                    data.forEach((record) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${record.username}</td>
                            <td>${record.email}</td>
                            <td><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteRecord(${record.id})">حذف</button></td>
                            <td><a href="edit_المستخدمين.php?id=${record.id}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">تعديل</a></td>
                        `;
                        recordsTable.appendChild(row);
                    });
                });
        }

        // Delete record
        async function deleteRecord(id) {
            if (confirm('هل تريد حذف هذا المستخدم؟')) {
                const response = await fetch('../backend/المستخدمين.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                });
                if (response.ok) {
                    loadRecords();
                } else {
                    alert('حدث خطأ أثناء حذف المستخدم');
                }
            }
        }

        // Load records on page load
        loadRecords();
    </script>
</body>
</html>

This code uses the Fetch API to load records from the backend and delete records using AJAX requests. It also includes a search bar that filters records in real-time. The UI is built using Tailwind CSS.