<?php
  # convert data from array to sql script
  # by masdjab, 200105
  
  function export_data_as_sql($conn, $column_names, $items) {
    if(($jml_data = count($items)) > 0) {
      $columns_str = join(", ", array_map(function($x){return "`$x`";}, $column_names));
      $query = "INSERT INTO customer($columns_str) VALUES \r\n";
      
      for($i = 0; $i < $jml_data; $i++) {
        $mapper = 
          function($x) use($conn) {
            return !is_null($x) ?  '"' . mysqli_escape_string($conn, $x) . '"' : "NULL";
          };
        $values_arr = array_map($mapper, $items[$i]);
        $values_str = join(", ", $values_arr);
        $query = $query . "(" . $values_str . ")" . ($i == ($jml_data - 1) ? ";" : ",") . "\r\n";
      }
      
      return $query;
    } else {
      return "";
    }
  }
  
  
  function test_export_data($conn, $column_names, $items) {
    if(strlen($sql = export_data_as_sql($conn, $column_names, $items)) > 0) {
      echo "$sql\r\n\r\n";
    } else {
      echo "Conversion skipped because data is empty\r\n\r\n";
    }
  }
  
  
  # usage example
  $mysqli = mysqli_connect("localhost", "root", "");
  
  echo "test with non empty data\r\n";
  test_export_data(
    $mysqli, 
    ["id_customer", "nm_customer", "alamat", "saldo"], 
    [
      ["C001", "Siti Marfu'ah", "Mrican\r\nGejayan", "Yogyakarta", 32000], 
      ["C002", "Aris Munandar", "Kotabaru", "Yogyakarta", null], 
      ["C003", "Zainal Arifin", null, "Yogyakarta", 2500000]
    ]
  );
  
  echo "test with empty data\r\n";
  test_export_data(
    $mysqli, 
    ["id_customer", "nm_customer", "alamat", "saldo"], 
    []
  );
?>
