<?php

function getEntries() {
    try {
        $loc = 'sqlite:/local/my_web_files/selarkin/cclc/cslab.db';
        $conn = new \PDO($loc, null,
                null, array(PDO::ATTR_PERSISTENT=>true));
        if ($conn == NULL) {
            #echo "failed";
        } else {
            #echo "... success\n";
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $vals = [];
        $stat = $conn->query('SELECT * FROM Queue WHERE');
        while ($row = $stat->fetch(\PDO::FETCH_ASSOC)) {
            $vals[] = $row;
        }
        echo json_encode($vals);
    } catch (PDOException $e) {
        echo "Conn failed: ".$e->getMessage();
    }
}

getEntries();

?>
