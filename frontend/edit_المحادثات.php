**edit_المحادثات.php**

<?php
session_start();

// Validate session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Fetch existing record details via GET
$url = '../backend/المحادثات.php?id=' . $id;
$response = file_get_contents($url);
$data = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المحادثات</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
        }
        .form-group input, .form-group select {
            width: 100%;
            height: 40px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">تعديل المحادثات</h2>
        <form id="edit-form">
            <div class="form-group">
                <label for="title">العنوان:</label>
                <input type="text" id="title" name="title" value="<?= $data['title'] ?>">
            </div>
            <div class="form-group">
                <label for="description">الوصف:</label>
                <textarea id="description" name="description"><?= $data['description'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">الحالة:</label>
                <select id="status" name="status">
                    <option value="active" <?= $data['status'] == 'active' ? 'selected' : '' ?>>نشط</option>
                    <option value="inactive" <?= $data['status'] == 'inactive' ? 'selected' : '' ?>>غير نشط</option>
                </select>
            </div>
            <button type="submit" class="btn">تعديل</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#edit-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'PUT',
                    url: '../backend/المحادثات.php',
                    data: formData,
                    success: function(response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'نجاح',
                                text: 'تم تعديل المحادثات بنجاح',
                                icon: 'success',
                            }).then(function() {
                                window.location.href = 'list_المحادثات.php';
                            });
                        } else {
                            Swal.fire({
                                title: 'فشل',
                                text: 'حدث خطأ أثناء تعديل المحادثات',
                                icon: 'error',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>


**backend/المحادثات.php**

<?php
// Validate session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Update record via PUT
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Update record in database
    $query = "UPDATE المحادثات SET title = '$title', description = '$description', status = '$status' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}

// Fetch existing record details via GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM المحادثات WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
}
?>