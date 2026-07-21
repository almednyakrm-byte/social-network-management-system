<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(to bottom, #1a1d23, #2c2f36);
            background-size: 100% 300px;
            background-position: 0% 100%;
            transition: background-position 0.5s ease-in-out;
        }
        .glassmorphic {
            background: linear-gradient(90deg, #1a1d23, #2c2f36);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient {
            background: linear-gradient(90deg, #1a1d23, #2c2f36);
            background-clip: padding-box;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-900 h-screen flex justify-center items-center">
    <div class="glassmorphic w-96 h-96 rounded-lg p-10 flex flex-col items-center justify-center">
        <h1 class="text-3xl font-bold text-slate-900 mb-5">Login</h1>
        <form id="login-form" class="flex flex-col items-center justify-center">
            <input type="text" id="username" name="username" class="w-full p-2 mb-5 text-slate-900 border border-slate-900 rounded-lg focus:outline-none focus:border-indigo-500" placeholder="Username" pattern="[A-Za-z\u0600-\u06FF0-9\s]+" required>
            <input type="password" id="password" name="password" class="w-full p-2 mb-5 text-slate-900 border border-slate-900 rounded-lg focus:outline-none focus:border-indigo-500" placeholder="Password" required>
            <button type="submit" class="w-full p-2 mb-5 text-slate-900 bg-indigo-500 hover:bg-indigo-700 rounded-lg focus:outline-none focus:border-indigo-500">Login</button>
            <p class="text-slate-900 text-center">Don't have an account? <a href="register.php" class="text-indigo-500 hover:text-indigo-700">Register</a></p>
        </form>
        <div id="error-alert" class="hidden mb-5 text-red-500"></div>
        <div id="success-alert" class="hidden mb-5 text-green-500"></div>
    </div>

    <script>
        const form = document.getElementById('login-form');
        const errorAlert = document.getElementById('error-alert');
        const successAlert = document.getElementById('success-alert');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('../backend/auth.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });

                const data = await response.json();

                if (data.success) {
                    successAlert.classList.remove('hidden');
                    successAlert.textContent = data.message;
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 2000);
                } else {
                    errorAlert.classList.remove('hidden');
                    errorAlert.textContent = data.message;
                }
            } catch (error) {
                errorAlert.classList.remove('hidden');
                errorAlert.textContent = 'Error: ' + error.message;
            }
        });
    </script>
</body>
</html>


This code creates a premium-looking login page with a glassmorphic layout, gradients, and a form for username and password input. It uses the Tailwind CSS CDN for styling and includes a beautiful glassmorphic layout with gradients. The form includes standard HTML input pattern validators to support Arabic and Latin characters. The AJAX JavaScript code uses the Fetch API to submit the credentials to the backend PHP script and handle the response or error alerts dynamically. The page also includes a direct link to the register.php page.