<?php
include('includes/auth.php');
include('includes/db.php');

$sql = "SELECT u.name AS user_name, r.title AS resource_title, l.accessed_at
        FROM usage_logs l
        JOIN users u ON l.user_id = u.id
        JOIN resources r ON l.resource_id = r.id
        ORDER BY l.accessed_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usage Tracking - Course Analysis System</title>
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
      <h1 class="text-3xl sm:text-4xl font-bold text-text-neutral">Resource Usage Log</h1>
    </header>

    <div class="bg-white shadow-md rounded-lg p-6">
      <div class="overflow-x-auto">
        <table class="w-full table-auto text-left">
          <thead class="border-b-2 border-accent-border">
            <tr>
              <th class="p-4 bg-indigo-50 text-indigo-800 font-bold">User</th>
              <th class="p-4 bg-indigo-50 text-indigo-800 font-bold">Resource</th>
              <th class="p-4 bg-indigo-50 text-indigo-800 font-bold">Accessed At</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="border-b border-slate-200 hover:bg-slate-100 odd:bg-slate-50 transition-colors">
                <td class="p-4"><?= htmlspecialchars($row['user_name']) ?></td>
                <td class="p-4"><?= htmlspecialchars($row['resource_title']) ?></td>
                <td class="p-4 font-mono text-sm"><?= htmlspecialchars($row['accessed_at']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <footer class="text-center mt-12">
      <a href="dashboard.php" class="font-medium text-primary hover:text-indigo-800">← Back to Dashboard</a>
    </footer>
  </div>
</body>
</html>
