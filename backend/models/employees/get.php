<?php
if (isset($_GET['datakey']) && sessionChecker()) {
  $limit = $_GET['length'];
  $offset = $_GET['start'];
  $sortColumn = "employees.name";
  $sortingDirection = "ASC";
  if (isset($_GET['order'])) {
    $columnIndex = $_GET['order'][0]['column'];
    $sortingDirection = $_GET['order'][0]['dir'];

    // Define an array that maps column indexes to database columns
    $columnMapping = array(
      0 => 'employees.name',
      1 => 'employees.name',
      2 => 'employees.name',
      3 => 'employees.name',
      4 => 'employees.createdat',
      5 => 'employees.updatedat',
    );

    // Determine the column name for sorting
    $sortColumn = $columnMapping[$columnIndex];
  }

  // filtering
  $columns = $_GET['columns'];
  $name = "%" . trim($columns[1]['search']['value'], "()") . "%";
  $filter = "";
  $filter .= " and employees.name like ? ";

   // actions
   $actioncol = '<div>
   <button class="action-button action-edit bg-warning" data-obj = "employees"><img src="./assets/icons/edit.svg" /></button>
   <button class="action-button action-delete bg-danger" data-obj = "employees"><img src="./assets/icons/delete.svg" /></button>
</div>';

  

  // queries
  $query = "select *,
  CONCAT(
    '" . $actioncol . "'
) AS `actions` from employees where accid = ? $filter
  ORDER BY $sortColumn $sortingDirection
  limit $limit offset $offset";
  $connection = connectDB();
    // execute main query
  $stmt = $connection->prepare("$query");
  $stmt->bind_param("is", $_SESSION['user']['accid'], $name);
  $stmt->execute();
  $result = $stmt->get_result();
  $res = $result->fetch_all(MYSQLI_ASSOC);
    // Count the total number of records
  $countQuery = "SELECT COUNT(*) AS total from employees where accid = ? $filter";
  $stmt = $connection->prepare("$countQuery");
  $stmt->bind_param("is", $_SESSION['user']['accid'], $name);
  $stmt->execute();
  $result = $stmt->get_result();
  $countRow = $result->fetch_all(MYSQLI_ASSOC);
  $totalRecords = $countRow[0]['total'];

  close_connection($connection, $stmt, false);
  $data = array(
    "checkdata" => $_GET,
    "draw" => $_GET['draw'],
    // Increment this value on each request
    "recordsTotal" => $totalRecords,
    // Total number of records (not just the ones on the current page)
    "recordsFiltered" => $totalRecords,
    // Total number of records after filtering (if any)
    "data" => $res
  );
  header('Content-Type: application/json');
  echo json_encode($data);
  die;
}
?>