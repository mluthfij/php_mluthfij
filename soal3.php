<?php
  $host = 'localhost';
  $user = 'root';
  $database = 'testdb';

  try {
      $pdo = new PDO("mysql:host=$host;charset=utf8", $user);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = file_get_contents('import.sql');

      $statements = array_filter(array_map('trim', explode(';', $sql)));

      foreach ($statements as $statement) {
          if (!empty($statement)) {
              try {
                  $pdo->exec($statement);
              } catch (PDOException $e) {
                  if (strpos($e->getMessage(), 'already exists') === false) {
                      echo "SQL Error: " . $e->getMessage() . "<br>";
                  }
              }
          }
      }

      $dsn = "mysql:host=localhost;dbname=testdb;charset=utf8";
      $pdo = new PDO($dsn, $user);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
      echo "Koneksi gagal: " . $e->getMessage();
  }

  $page = $_GET['page'] ?? 'default';

  $nama   = $_POST['f_name']   ?? '';
  $alamat = $_POST['f_alamat'] ?? '';

  $sql = "SELECT p.*, h.hobi 
          FROM person p
          LEFT JOIN hobi h ON p.id = h.person_id
          WHERE 1=1";

  $params = [];

  if ($page === 'result') {
      if ($nama !== '') {
          $sql .= " AND p.nama LIKE :nama";
          $params[':nama'] = "%$nama%";
      }
      if ($alamat !== '') {
          $sql .= " AND p.alamat LIKE :alamat";
          $params[':alamat'] = "%$alamat%";
      }
  }

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soal 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-5">
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Hobi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['hobi'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="card my-5" style="width: 32rem;">
        <div class="card-body">
          <form method="post" action="?page=result">
            <label for="f_name">Nama :</label>
            <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($nama) ?>"><br><br>

            <label for="f_alamat">Alamat :</label>
            <input type="text" id="f_alamat" name="f_alamat" value="<?= htmlspecialchars($alamat) ?>"><br><br>

            <input type="submit" value="SEARCH">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
