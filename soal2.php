<?php
  session_start();

  $page = $_GET['page'] ?? 'nama';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['f_name'])) {
        $_SESSION['nama'] = $_POST['f_name'];
    }
    if (isset($_POST['f_umur'])) {
        $_SESSION['umur'] = $_POST['f_umur'];
    }
    if (isset($_POST['f_hobi'])) {
        $_SESSION['hobi'] = $_POST['f_hobi'];
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soal 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
      <?php
        if ($page === 'nama'): ?>
          <div class="card" style="width: 32rem;">
            <div class="card-body">
              <form method="post" action="/soal2.php?page=umur">
                <label for="f_name">Nama Anda:</label>
                <input type="text" id="f_name" name="f_name"><br><br>
                <input type="submit" value="SUBMIT">
              </form>
            </div>
          </div>

        <?php elseif ($page === 'umur'): ?>
          <div class="card" style="width: 32rem;">
            <div class="card-body">
              <form method="post" action="/soal2.php?page=hobi">
                <label for="f_umur">Umur Anda:</label>
                <input type="number" id="f_umur" name="f_umur"><br><br>
                <input type="submit" value="SUBMIT">
              </form>
            </div>
          </div>

        <?php elseif ($page === 'hobi'): ?>
          <div class="card" style="width: 32rem;">
            <div class="card-body">
              <form method="post" action="/soal2.php?page=detail">
                <label for="f_hobi">Hobi Anda:</label>
                <input type="text" id="f_hobi" name="f_hobi"><br><br>
                <input type="submit" value="SUBMIT">
              </form>
            </div>
          </div>

        <?php elseif ($page === 'detail'): ?>
          <?php
            $fields = [
              'Nama' => $_SESSION['nama'] ?? '-',
              'Umur' => $_SESSION['umur'] ?? '-',
              'Hobi' => $_SESSION['hobi'] ?? '-'
            ];
          ?>
          <?php foreach ($fields as $label => $value): ?>
            <p><?= $label ?>: <?= htmlspecialchars($value) ?></p>
          <?php endforeach; ?>

        <?php else: ?>
          <h2>404 - Page not found</h2>
        <?php endif; ?>
    </div>
  </body>
</html>