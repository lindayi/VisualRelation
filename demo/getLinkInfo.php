<?php 
    include_once "conn.php";

    $source = $_GET['source'];
    $target = $_GET['target'];

    $sqlquery = "SELECT DISTINCT type, ne, text, pubtime, realtime FROM relation,doc WHERE sourceid =".$source." AND destid = ".$target." AND relation.doc = doc.file AND relation.sentenceid = doc.sentenceid";
    
    $result = mysql_query($sqlquery, $conn);
    
    $row = mysql_fetch_array($result);

    $source = array(
        'text' => $row['text'],
        'realtime' => $row['realtime'],
        'pubtime' => $row['pubtime']
    );
    // array_push($source, 'text' => $row['text']);
    // array_push($source, 'realtime' => $row['realtime']);
    // array_push($source, 'pubtime' => $row['pubtime']);

    $sources = array();
    array_push($sources, $source);

    $link = array(
        "type" => $row['type'],
        "ne" => $row['ne']
    );
    // array_push($link, "type" => $row['type']);
    // array_push($link, "ne" => $row['ne']);

    while ($row = mysql_fetch_array($result)) {
        $source = array(
        'text' => $row['text'],
        'realtime' => $row['realtime'],
        'pubtime' => $row['pubtime']
        );
        // array_push($source, 'text' => $row['text']);
        // array_push($source, 'realtime' => $row['realtime']);
        // array_push($source, 'pubtime' => $row['pubtime']);

        array_push($sources, $source);
    }
    array_push($link, $sources);
    
   echo json_encode($link);
 ?>