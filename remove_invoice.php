<?php
require_once 'dbconnection.php';

$dbcon = createDbConnection();

$invoice_id = 3;

$sql = "DELETE FROM invoice_items WHERE InvoiceLineId=$invoice_id";
$statement = $dbcon->prepare($sql);
$statement->execute();