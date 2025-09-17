<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Course Analysis System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366F1', // Indigo
            secondary: '#10B981', // Emerald Green
            background: '#F1F5F9', // Light Gray
            'text-neutral': '#374151', // Neutral Gray
            'accent-border': '#334155', // Slate-700
          }
        }
      }
    }
  </script>
</head>
<body class="h-full bg-background flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
      <h2 class="text-2xl font-bold text-center text-text-neutral mb-6">Login</h2>
      <form action="login.php" method="POST">
        <div class="mb-4">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="email">
            Email
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="email" type="email" name="email" required placeholder="you@example.com">
        </div>
        <div class="mb-6">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="password">
            Password
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="password" type="password" name="password" required placeholder="************">
        </div>
        <div class="flex items-center justify-between">
          <button class="bg-primary hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-md w-full focus:outline-none focus:shadow-outline" type="submit">
            Login
          </button>
        </div>
      </form>
    </div>
    <p class="text-center text-gray-500 text-xs">
      &copy;2024 Course Analysis System. All rights reserved.
    </p>
  </div>
</body>
</html>
