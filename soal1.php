<?php
  $jml = $_GET['jml'];
  echo "<table border=1>\n";
  for ($a = $jml; $a > 0; $a--)
  {
    $total = ($a * ($a + 1)) / 2;

    echo "<tr>\n";
    echo "<th>TOTAL: $total</th>";
    echo "</tr>\n";

    echo "<tr>\n";
    for ($b = $a; $b > 0; $b--)
    {
      echo "<td>$b</td>";
    }
    echo "</tr>\n";
  }
  echo "</table>";
?>