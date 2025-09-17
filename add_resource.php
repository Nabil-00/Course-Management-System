<?php
include('includes/auth.php');
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $type = $_POST['type'];
  $tags = $_POST['tags'];

  // Default empty path
  $path = '';

  if ($type === 'pdf' && isset($_FILES['pdf']['name']) && $_FILES['pdf']['name'] !== '') {
    $target_dir = "assets/uploads/";
    $file_name = basename($_FILES["pdf"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
      $path = $target_file;
    } else {
      $message = "❌ Error uploading the PDF.";
    }
  } elseif (($type === 'link' || $type === 'video') && !empty($_POST['link'])) {
    $path = $_POST['link'];
  }

  if ($path !== '') {
    $sql = "INSERT INTO resources (title, type, path, tags) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $type, $path, $tags);

    if ($stmt->execute()) {
      $message = "Resource uploaded successfully!";
    } else {
      $message = "Database error: " . $conn->error;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Resource - Course Analysis System</title>
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
      <h2 class="text-2xl font-bold text-center text-text-neutral mb-6">Upload New Resource</h2>
      
      <?php 
        if (isset($message)) {
          $is_error = strpos($message, 'Error') !== false || strpos($message, '❌') !== false;
          $alert_class = $is_error ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700';
          echo "<div class='{$alert_class} border px-4 py-3 rounded-md relative mb-4' role='alert'>{$message}</div>";
        }
      ?>

      <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
          <label class="block text-text-neutral text-sm font-bold mb-2" for="title">
            Resource Title
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="title" type="text" name="title" required>
        </div>

        <div>
          <label class="block text-text-neutral text-sm font-bold mb-2" for="type">
            Resource Type
          </label>
          <select class="shadow-sm border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="type" name="type" onchange="toggleFields()" required>
            <option value="pdf">PDF</option>
            <option value="link">Web Link</option>
            <option value="video">Video Link</option>
          </select>
        </div>

        <div id="pdf_upload">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="pdf">
            Select PDF file
          </label>
          <input class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" id="pdf" type="file" name="pdf" accept="application/pdf">
        </div>
        
        <div id="link_input" style="display:none;">
          <label class="block text-text-neutral text-sm font-bold mb-2" for="link">
            Paste Link
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="link" type="url" name="link" placeholder="https://...">
        </div>

        <div>
          <label class="block text-text-neutral text-sm font-bold mb-2" for="tags">
            Tags (comma separated)
          </label>
          <input class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-text-neutral leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="tags" type="text" name="tags">
        </div>

        <div>
          <button class="bg-primary hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-md w-full focus:outline-none focus:shadow-outline" type="submit">
            Upload Resource
          </button>
        </div>
      </form>
    </div>
    <div class="text-center">
      <a href="dashboard.php" class="font-medium text-primary hover:text-indigo-800">← Back to Dashboard</a>
    </div>
  </div>

  <script>
    function toggleFields() {
      const type = document.getElementById('type').value;
      document.getElementById('pdf_upload').style.display = (type === 'pdf') ? 'block' : 'none';
      document.getElementById('link_input').style.display = (type !== 'pdf') ? 'block' : 'none';
    }
  </script>
</body>
</html>
