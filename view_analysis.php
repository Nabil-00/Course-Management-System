<?php
include('includes/auth.php');
include('includes/db.php');

// Fetch all courses
$courses = $conn->query("SELECT * FROM courses");

function getResourcesForCourse($conn, $course_id) {
  $sql = "SELECT r.title, r.type, r.path, r.tags
          FROM resources r
          JOIN course_resource_map m ON r.id = m.resource_id
          WHERE m.course_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  return $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Analysis - Course Analysis System</title>
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
  <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
    <header class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-text-neutral">Course Resource Analysis</h1>
    </header>

    <main class="space-y-8">
      <?php while ($course = $courses->fetch_assoc()): ?>
        <div class="bg-white shadow-md rounded-lg p-6">
          <h3 class="text-2xl font-bold text-text-neutral"><?= htmlspecialchars($course['title']) ?></h3>
          <p class="text-md text-gray-500 mb-4"><?= htmlspecialchars($course['department']) ?></p>
          <p class="text-gray-700 mb-6"><strong>Objectives:</strong> <?= htmlspecialchars($course['objectives']) ?></p>

          <hr class="my-4">

          <h4 class="text-lg font-semibold mb-4">Linked Resources</h4>
          <?php
            $resources = getResourcesForCourse($conn, $course['id']);
            if ($resources->num_rows > 0):
          ?>
            <ul class="space-y-4">
              <?php while ($res = $resources->fetch_assoc()): ?>
                <li class="flex items-center justify-between p-3 bg-slate-50 rounded-md">
                  <div class="flex items-center">
                    <span class="text-2xl mr-4">
                      <?php 
                        if ($res['type'] == 'pdf') echo '📄';
                        elseif ($res['type'] == 'video') echo '🎥';
                        else echo '🔗';
                      ?>
                    </span>
                    <div>
                      <strong class="font-semibold text-text-neutral"><?= htmlspecialchars($res['title']) ?></strong>
                      <p class="text-sm text-gray-500">Type: <?= htmlspecialchars($res['type']) ?> | Tags: <span class="font-mono bg-gray-200 px-2 py-1 rounded-md text-xs"><?= htmlspecialchars($res['tags']) ?: 'None' ?></span></p>
                    </div>
                  </div>
                  <div>
                  <?php if ($res['type'] == 'pdf'): ?>
  <a href="track.php?resource_id=<?= $res['id'] ?>" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 font-bold py-2 px-4 rounded-md text-sm transition-colors">Download PDF</a>
<?php else: ?>
  <a href="track.php?resource_id=<?= $res['id'] ?>" target="_blank" class="bg-secondary/10 text-secondary hover:bg-secondary/20 font-bold py-2 px-4 rounded-md text-sm transition-colors">Open Link</a>
<?php endif; ?>

                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p class="text-gray-500 italic">No resources linked to this course.</p>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </main>

    <footer class="text-center mt-12">
      <a href="dashboard.php" class="font-medium text-primary hover:text-indigo-800">← Back to Dashboard</a>
    </footer>
  </div>
</body>
</html>
