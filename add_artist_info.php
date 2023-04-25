<?php
require_once 'dbconnection.php';
$dbcon = createDbConnection();


try{
    $dbcon->beginTransaction();

    // Add artist:
        $statement = $dbcon->prepare("INSERT INTO artists (Name) VALUES (:artist_name)");
        $statement->bindParam(":artist_name", strip_tags($_POST['artist_name']));
        $statement->execute();

    // Get the artist Id for the album:
        $artistId = $dbcon->lastInsertId();

    //Add album for the new artist:
        $statement = $dbcon->prepare("INSERT INTO albums (Title, ArtistId) VALUES (:album_name, :artist_id)");
        $statement->bindParam(":album_name", strip_tags($_POST['album_name']));
        $statement->bindParam(":artist_id", strip_tags($artistId));
        $statement->execute();
    

    // Album id for the tracks:
        $albumId = $dbcon->lastInsertId();
   
    // Add tracks for this album:
        foreach ($_POST['tracks'] as $track){
            $statement = $dbcon->prepare("INSERT INTO tracks (Name, AlbumId) VALUES (:track_name, :album_id)");
        $statement->bindParam(":track_name", strip_tags($track['trackName']));
        $statement->bindParam(":album_id", $albumId);
        $statement->execute();
        }
    
    // Commit:
    $dbcon->commit();
    echo "Artist info added succesfully!";

}catch(Exception $e){

    $dbcon->rollBack();
    echo $e->getMessage();
}