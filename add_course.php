<?php
include('includes/auth.php');
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $department = $_POST['department'];
  $objectives = $_POST['objectives'];

  $sql = "INSERT INTO courses (title, department, objectives) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $title, $department, $objectives);

  if ($stmt->execute()) {
    $message = "Course added successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Course - Course Analysis System</title>
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
<body class="bg-background flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-lg">
    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
      <h2 class="text-2xl font-bold text-center text-text-neutral mb-6">Add New Course</h2>
      
      <?php 
        if (isset($message)) {
          // Basic alert styling without modifying the echo content itself.
          // NOTE: This cannot be styled as success/error without changing the PHP logic.
          $alert_type_class = strpos($message, 'Error') !== false ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700';
          echo "<div class='{$alert_type_class} border px-4 py-3 rounded-md relative mb-4' role='alert'>{$message}</div>";
        }
      ?>

      <form method="POST" action="add_course.php">
        <div class="mb-4">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="title">
            Course Title
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="title" type="text" name="title" required>
        </div>

        <div class="mb-4">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="department">
            Department
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="department" type="text" name="department" required>
        </div>

        <div class="mb-6">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="objectives">
            Objectives
          </label>
          <textarea class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="objectives" name="objectives" rows="4" required></textarea>
        </div>

        <div class="flex items-center justify-between">
          <button class="bg-primary hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-md w-full focus:outline-none focus:shadow-outline" type="submit">
            Add Course
          </button>
        </div>
      </form>
    </div>
    <div class="text-center">
      <a href="dashboard.php" class="font-medium text-primary hover:text-indigo-800">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
