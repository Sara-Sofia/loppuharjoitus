<?php
require_once 'dbconnection.php';
$dbcon = createDbConnection();
$artist_id =7;

try{
    $dbcon->beginTransaction();

    // Delete invoice items:
    $statement = $dbcon->prepare("DELETE FROM invoice_items WHERE TrackId IN 
    (SELECT TrackId FROM tracks WHERE AlbumId IN 
    (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id))");
    $statement->execute();

    // Delete invoices:
    $statement = $dbcon->prepare("DELETE FROM invoices WHERE InvoiceId IN 
    (SELECT InvoiceId FROM invoice_items WHERE TrackId IN 
    (SELECT TrackId FROM tracks WHERE AlbumId IN 
    (SELECT AlbumId FROM albums WHERE ArtistId= $artist_id)))");
    $statement->execute();

    //Delete playlist tracks:
    $statement = $dbcon->prepare("DELETE FROM playlist_track WHERE TrackId IN
    (SELECT TrackId FROM tracks WHERE AlbumId IN 
    (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id))");
    $statement->execute();

    //Delete tracks:
    $statement = $dbcon->prepare("DELETE FROM tracks WHERE AlbumId IN
    (SELECT AlbumId FROM albums WHERE ArtistId= $artist_id)");
    $statement->execute();

    // Delete artist:
    $statement = $dbcon->prepare("DELETE FROM artists WHERE ArtistId = $artist_id");
    $statement->execute();

    $dbcon->commit();
    echo "Data deleted successfully!";

}catch(Exception $e){

    $dbcon->rollBack();
    echo $e->getMessage();
}