<?php
require_once 'dbconnection.php';
$dbcon = createDbConnection();

$artistId=90;
$sql = "SELECT artists.Name AS Artist, albums.Title AS Album, tracks.Name AS track FROM artists, albums, tracks WHERE artists.ArtistId= albums.ArtistId AND albums.AlbumId = tracks.AlbumId AND artists.artistId = $artistId";
$statement = $dbcon->prepare($sql);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach($rows as $row) {
    $grouped[$row['Artist']][$row['Album']][]=$row['track'];
}

$output = [];
foreach($grouped as $artist => $albums){
    $albumList=[];
    foreach($albums as $album => $tracks){
        $albumList[]=[
            'Title'=> $album,
            'tracks' => $tracks
        ];
    }
    $output[]=[
        'Artist' => $artist,
        'Album' => $albumList
    ];
}
$json = json_encode($output);
header('Content-type: application/json');
echo $json;

