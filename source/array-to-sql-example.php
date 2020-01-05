<?php
  # contoh export data ke format SQL
  
  $kolom_data = ["id_customer", "nm_customer", "alamat", "saldo"];
  $contoh_data = 
    [
      ["C001", "Siti Marfu'ah", "Mrican\r\nGejayan", "Yogyakarta", 32000], 
      ["C002", "Aris Munandar", "Kotabaru", "Yogyakarta", 125000], 
      ["C003", "Zainal Arifin", "Umbulharjo", "Yogyakarta", 2500000]
    ];
  
  $mysqli = mysqli_connect("localhost", "root", "");
  $query = "INSERT INTO customer(" . join(", ", array_map(function($x){return "`$x`";}, $kolom_data)) . ") VALUES \r\n";
  $jml_data = count($contoh_data);
  for($i = 0; $i < $jml_data; $i++) {
    $values_arr = array_map(function($x) use($mysqli) {return '"' . mysqli_escape_string($mysqli, $x) . '"';}, $contoh_data[$i]);
    $values_str = join(", ", $values_arr);
    $query = $query . "(" . $values_str . ")" . ($i == ($jml_data - 1) ? ";" : ",") . "\r\n";
  }
  
  echo "query insert:\r\n";
  echo $query;
?>
