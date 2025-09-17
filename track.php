<?php
include('includes/auth.php');
include('includes/db.php');

if (isset($_GET['resource_id'])) {
  $user_id = $_SESSION['user_id'];
  $resource_id = intval($_GET['resource_id']);

  // Log the access
  $stmt = $conn->prepare("INSERT INTO usage_logs (user_id, resource_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $user_id, $resource_id);
  $stmt->execute();

  // Get the actual resource link
  $res = $conn->prepare("SELECT path FROM resources WHERE id = ?");
  $res->bind_param("i", $resource_id);
  $res->execute();
  $result = $res->get_result();
  $row = $result->fetch_assoc();

  if ($row) {
    header("Location: " . $row['path']);
    exit;
  } else {
    echo "Invalid resource.";
  }
} else {
  echo "No resource specified.";
}
?>
