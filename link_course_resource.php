<?php
include('includes/auth.php');
include('includes/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $course_id = $_POST['course_id'];
  $resource_id = $_POST['resource_id'];

  $sql = "INSERT INTO course_resource_map (course_id, resource_id) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $course_id, $resource_id);

  if ($stmt->execute()) {
    $message = "Resource linked to course successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
}

// Fetch courses and resources
$courses = $conn->query("SELECT id, title FROM courses");
$resources = $conn->query("SELECT id, title FROM resources");
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Link Resource to Course - Course Analysis System</title>
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
      <h2 class="text-2xl font-bold text-center text-text-neutral mb-6">Link Resource to a Course</h2>
      
      <?php 
        if (isset($message)) {
          $is_error = strpos($message, 'Error') !== false;
          $alert_class = $is_error ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700';
          echo "<div class='{$alert_class} border px-4 py-3 rounded-md relative mb-4' role='alert'>{$message}</div>";
        }
      ?>

      <form method="POST" class="space-y-6">
        <div>
          <label class="block text-text-neutral text-sm font-bold mb-2" for="course_id">
            Select Course
          </label>
          <select class="shadow-sm border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="course_id" name="course_id" required>
            <option value="">-- Choose Course --</option>
            <?php while ($course = $courses->fetch_assoc()): ?>
              <option value="<?= htmlspecialchars($course['id']) ?>"><?= htmlspecialchars($course['title']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div>
          <label class="block text-text-neutral text-sm font-bold mb-2" for="resource_id">
            Select Resource
          </label>
          <select class="shadow-sm border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="resource_id" name="resource_id" required>
            <option value="">-- Choose Resource --</option>
            <?php while ($resource = $resources->fetch_assoc()): ?>
              <option value="<?= htmlspecialchars($resource['id']) ?>"><?= htmlspecialchars($resource['title']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div>
          <button class="bg-primary hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-md w-full focus:outline-none focus:shadow-outline" type="submit">
            Link Resource
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
