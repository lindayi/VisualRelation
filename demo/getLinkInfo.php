<?php 
    /*
     * @description: encoding mysql result set to json
     * @format: {
            'ne': xxx, 
            'type': xxx, 
            'sources':[
                {
                    'text': xxx,
                    'realtime': xxx,
                    'pubtime': xxx,
                },
                {
                    'text': xxx,
                    'realtime': xxx,
                    'pubtime': xxx,
                },
            ]
            }
     *
     */

    include_once "conn.php"; 
    $source = $_GET['source'];
    $target = $_GET['target'];
    $coexist = $_GET['coexist'];

    $sqlquery = "SELECT DISTINCT type, ne, text, pubtime, realtime FROM relation,doc WHERE sourceid =".$source." AND destid = ".$target." AND relation.doc = doc.file AND relation.sentenceid = doc.sentenceid";
    if(!$coexist) $sqlquery = $sqlquery." AND relation.type not like 'CeCoexist%' ";
    //echo $sqlquery;
    $result = mysql_query($sqlquery, $conn);
    
    $row = mysql_fetch_array($result);

    $source = array(
        'text' => $row['text'],
        'realtime' => $row['realtime'],
        'pubtime' => $row['pubtime']
    );

    $sources = array();
    array_push($sources, $source);

    $type = $row['type'];
    $ne   = $row['ne'];

    while ($row = mysql_fetch_array($result)) {
        $source = array(
        'text' => $row['text'],
        'realtime' => $row['realtime'],
        'pubtime' => $row['pubtime']
        );
        array_push($sources, $source);
    }

    $link = array(
        'type'=>$type,
        'ne'=>$ne,
        'sources'=>$sources
        );

    echo json_encode($link);
 ?>