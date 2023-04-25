<?php
require_once 'dbconnection.php';

$dbcon = createDbConnection();

$playlist_id = 1;

$sql = "SELECT tracks.TrackId, Name, Composer FROM playlist_track, tracks WHERE playlist_track.TrackId = tracks.TrackId AND PlaylistId=$playlist_id";
$statement = $dbcon->prepare($sql);
$statement->execute();
$rows = $statement->fetchall(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo '<h2>'.$row["Name"].'<br>'.'</h2>'.'('.$row['Composer'].')'.'<br>';
}
