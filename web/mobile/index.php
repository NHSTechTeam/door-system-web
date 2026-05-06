<?php
// Optional: session_start(); to handle sessions later
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tech Club Door</title>
  <link rel="manifest" href="manifest.json">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <meta name="theme-color" content="#121212">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark text-light">
  <div class="container mt-5">
    <div class="text-center mb-4">
      <h1>Tech Team Door</h1>
      <p class="lead">Enter your username and mobile unlock code</p>
    </div>

    <form action="/mobile/unlock.php" method="POST" class="mx-auto" style="max-width: 400px;">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control bg-dark text-light border-secondary" id="username" name="username" autocomplete="username" required>
      </div>
      <div class="mb-4">
        <label for="code" class="form-label">Unlock Code</label>
        <input type="password" class="form-control bg-dark text-light border-secondary" id="code" name="code" autocomplete="one-time-code"required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Unlock</button>
    </form>

    <?php if (isset($_GET['status'])): ?>
      <div class="alert mt-4 <?= $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($_GET['message'] ?? ($_GET['status'] === 'success' ? 'Door Unlocked!' : 'Invalid Code')) ?>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>