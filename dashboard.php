<?php
include('includes/auth.php');
include('includes/db.php');
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Course Analysis System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366F1', // Indigo
            secondary: '#10B981', // Emerald Green
            background: '#F1F5F9', // Light Gray (Slate-100)
            'text-neutral': '#374151', // Neutral Gray
            'accent-border': '#334155', // Slate-700
          }
        }
      }
    }
  </script>
</head>
<body class="bg-background font-sans text-text-neutral">
  <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl min-h-screen flex flex-col">
    <header class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-text-neutral mb-4">Welcome to Course Analysis System</h1>
      <?php
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        echo "<p class=\"text-md\">You are logged in as: <span class=\"font-semibold bg-primary/20 text-primary py-1 px-3 rounded-full text-sm\">" . htmlspecialchars($role) . "</span></p>";
      ?>
    </header>

    <main class="flex-grow">
      <?php
        if ($role === 'admin') {
          // Use single quotes for the echo string to avoid escaping all the double quotes inside.
          echo '
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <a href="add_course.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-4">
                <span class="text-4xl">📘</span>
                <div>
                  <h3 class="text-xl font-bold text-text-neutral">Add New Course</h3>
                  <p class="text-gray-500 mt-1">Define a new course structure.</p>
                </div>
              </a>
              <a href="add_resource.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-4">
                <span class="text-4xl">📂</span>
                <div>
                  <h3 class="text-xl font-bold text-text-neutral">Upload Resource</h3>
                  <p class="text-gray-500 mt-1">Add new learning materials.</p>
                </div>
              </a>
              <a href="link_course_resource.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-4">
                <span class="text-4xl">🔗</span>
                <div>
                  <h3 class="text-xl font-bold text-text-neutral">Link Course to Resources</h3>
                  <p class="text-gray-500 mt-1">Connect resources to courses.</p>
                </div>
              </a>
              <a href="view_analysis.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-4">
                <span class="text-4xl">📊</span>
                <div>
                  <h3 class="text-xl font-bold text-text-neutral">View Course Analysis</h3>
                  <p class="text-gray-500 mt-1">See course performance data.</p>
                </div>
              </a>
              <a href="usage_tracking.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-4 md:col-span-2">
                <span class="text-4xl">📈</span>
                <div>
                  <h3 class="text-xl font-bold text-text-neutral">Track Usage</h3>
                  <p class="text-gray-500 mt-1">Monitor user engagement across resources.</p>
                </div>
              </a>
            </div>
          ';
        } elseif ($role === 'student') {
          echo "<div class=\"bg-white text-center p-8 rounded-lg shadow-md\"><p>Coming soon: Student dashboard (recommended resources, activity log)</p></div>";
        } elseif ($role === 'instructor') {
          echo "<div class=\"bg-white text-center p-8 rounded-lg shadow-md\"><p>Coming soon: Instructor tools to manage courses and monitor resource usage</p></div>";
        } elseif ($role === 'librarian') {
          echo "<div class=\"bg-white text-center p-8 rounded-lg shadow-md\"><p>Coming soon: Librarian tools for resource management</p></div>";
        }
      ?>
    </main>

    <footer class="text-center mt-12 mb-4">
      <a href="logout.php" class="text-gray-500 hover:text-primary hover:underline transition-colors duration-300">Logout</a>
    </footer>
  </div>
</body>
</html>
