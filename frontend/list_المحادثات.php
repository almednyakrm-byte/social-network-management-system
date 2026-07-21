**list_المحادثات.php**

<?php
session_start();

// Check if user is authenticated
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
    <title>المحادثات</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
        }
        .header {
            background-color: #1f2937;
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
            background-color: #f0f0f0;
        }
        .search-bar {
            width: 50%;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }
        .search-bar input[type="search"] {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 0.5rem;
        }
        .search-bar input[type="search"]:focus {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(13, 130, 184, 0.5);
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">الرئيسية</a>
        <span class="text-white"> | </span>
        <span class="text-white"><?= $_SESSION['username'] ?></span>
        <span class="text-white"> | </span>
        <a href="logout.php">تسجيل خروج</a>
    </div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">المحادثات</h1>
        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_المحادثات.php'">إضافة جديد</button>
        <div class="search-bar">
            <input type="search" id="search-input" placeholder="بحث...">
            <button class="bg-slate-900 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded" onclick="searchRecords()">بحث</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>عنوان المحادثة</th>
                    <th>تاريخ الإضافة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="records-table">
                <!-- Records will be loaded here -->
            </tbody>
        </table>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const recordsTable = document.getElementById('records-table');

        function searchRecords() {
            const searchQuery = searchInput.value.trim();
            if (searchQuery) {
                fetch('../backend/المحادثات.php?search=' + searchQuery)
                    .then(response => response.json())
                    .then(data => {
                        recordsTable.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.title}</td>
                                <td>${record.date}</td>
                                <td>
                                    <a href="edit_المحادثات.php?id=${record.id}" class="text-indigo-500 hover:text-indigo-700">تعديل</a>
                                    <button class="text-red-500 hover:text-red-700" onclick="deleteRecord(${record.id})">حذف</button>
                                </td>
                            `;
                            recordsTable.appendChild(row);
                        });
                    })
                    .catch(error => console.error(error));
            } else {
                fetch('../backend/المحادثات.php')
                    .then(response => response.json())
                    .then(data => {
                        recordsTable.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.title}</td>
                                <td>${record.date}</td>
                                <td>
                                    <a href="edit_المحادثات.php?id=${record.id}" class="text-indigo-500 hover:text-indigo-700">تعديل</a>
                                    <button class="text-red-500 hover:text-red-700" onclick="deleteRecord(${record.id})">حذف</button>
                                </td>
                            `;
                            recordsTable.appendChild(row);
                        });
                    })
                    .catch(error => console.error(error));
            }
        }

        function deleteRecord(id) {
            if (confirm('هل تريد حذف هذا السجل؟')) {
                fetch('../backend/المحادثات.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم حذف السجل بنجاح');
                        searchRecords();
                    } else {
                        alert('حدث خطأ أثناء حذف السجل');
                    }
                })
                .catch(error => console.error(error));
            }
        }

        searchRecords();
    </script>
</body>
</html>

**backend/المحادثات.php**

<?php
// Database connection code here
// ...

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $results = $db->query("SELECT * FROM المحادثات WHERE title LIKE '%$searchQuery%' OR date LIKE '%$searchQuery%'");
} else {
    $results = $db->query("SELECT * FROM المحادثات");
}

$data = array();
while ($row = $results->fetch_assoc()) {
    $data[] = $row;
}

if (isset($_GET['search'])) {
    echo json_encode(array('data' => $data));
} else {
    echo json_encode(array('data' => $data));
}

Note: This code assumes you have a database connection established and a table named `المحادثات` with columns `id`, `title`, and `date`. You'll need to modify the database connection code and the SQL queries to match your actual database schema. Additionally, this code uses a simple search query that may not be efficient for large datasets. You may want to consider using a more advanced search query or indexing your database for better performance.