<?php
if (isset($_GET['datakey']) && sessionChecker()) {
  $limit = $_GET['length'];
  $offset = $_GET['start'];
  $sortColumn = "sales.id";
  $sortingDirection = "ASC";
  if (isset($_GET['order'])) {
    $columnIndex = $_GET['order'][0]['column'];
    $sortingDirection = $_GET['order'][0]['dir'];

    // Define an array that maps column indexes to database columns
    $columnMapping = array(
      0 => 'sales.id',
      1 => 'clients.name',
      2 => 'employees.name',
      3 => 'sales.id',
      4 => 'sales.id',
      5 => 'sales.id',
      6 => 'sales.id',
      7 => 'sales.createdat',
      8 => 'sales.updatedat',
    );

    // Determine the column name for sorting
    $sortColumn = $columnMapping[$columnIndex];
  }

  // filtering
  $columns = $_GET['columns'];
  $name = "%" . trim($columns[1]['search']['value'], "()") . "%";
  $filter = "";
  $filter .= " and clients.name like ? ";

   // actions
   $actioncol = '<div>
   <button class="action-button action-edit bg-warning" data-obj = "sales"><img src="./assets/icons/edit.svg" /></button>
   <button class="action-button action-delete bg-danger" data-obj = "sales"><img src="./assets/icons/delete.svg" /></button>
</div>';

  

  // queries
  $query = "select clients.name as `clientName`, employees.name as `employeeName`, amount_paid, total_amount, discount_amount, amount_after_discount, sales.createdat, sales.updatedat,
  CONCAT(
    '" . $actioncol . "'
) AS `actions` from sales, clients, employees where sales.clientid = clients.id and sales.employeeid = employees.id and employees.accid = ? $filter
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
  $countQuery = "SELECT COUNT(*) AS total from sales, clients, employees where sales.clientid = clients.id and sales.employeeid = employees.id and employees.accid = ? $filter";
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