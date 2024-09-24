<?php

$a = array();
$i = 0;
$q = $_POST["buzz"];

#echo var_dump($_POST);
#echo $_POST["type"];
if ($_POST["type"] == "insert") {
    #echo 'succ';
    addEntry();
} else if ($_POST["type"] == "fetch"){
    #echo "fetcheroo";
    getEntries();
} else if ($_POST["type"] == "del") {
#    echo 'delete a question?';
    updateEntry();
} else {
    echo 'blah';
}

function updateEntry() {
    try {
        echo "updating database Question";
        $conn = new \PDO('sqlite:/local/my_web_files/selarkin/cclc/cslab.db',
            null, null, array(PDO::ATTR_PERSISTENT=>true));
        echo "whoo";
        if ($conn == NULL) {
            echo "failed";
        } else {
            echo "...success\n";
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "attribute set\n";
        # the line below uses prepare and :name to prevent SQL injection
        $stat = $conn->prepare('UPDATE Queue 
                SET time_del = datetime(\'now\', \'localtime\'), 
                    removed_by=:remover 
                WHERE
                    num = :nums');
        echo "prepared...\n";
        $rem = 0;
        echo var_dump($_POST);  
        if ($_POST["role"] == "student") {
            $rem = 1;
        } else if ($_POST["role"] == "coach") {
            $rem = 2;
        }
        $nums = $_POST["nums"];
        $res = $stat->execute([':remover'=>$rem, ':nums'=>$nums]);
        echo "exec'd\n";
#echo "yippee!";
        echo $res;



    } catch (PDOException $e) {
        echo "Conn Failed: ".$e->getMessage();
    }

}

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
        $stat = $conn->query('SELECT * FROM Queue WHERE removed_by = 0');
        while ($row = $stat->fetch(\PDO::FETCH_ASSOC)) {
            $vals[] = $row;
        }
        echo json_encode($vals);
    } catch (PDOException $e) {
        echo "Conn failed: ".$e->getMessage();
    }
}

function addEntry() {
    try {
        echo "creating database Question";
        $conn = new \PDO('sqlite:/local/my_web_files/selarkin/cclc/cslab.db',
            null, null, array(PDO::ATTR_PERSISTENT=>true));
        echo "whoo";
        if ($conn == NULL) {
            echo "failed";
        } else {
            echo "...success\n";
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "attribute set\n";
        # the line below uses prepare and :name to prevent SQL injection
        $stat = $conn->prepare('INSERT INTO Queue VALUES(null, 
                :gnum, :labSec, datetime(\'now\', \'localtime\'), null, 0,
                :qtext, :qnum, :reason, :status)');
        echo "prepared...\n";
        $gnum = $_POST["group"];
        $labSec = $_POST["lab-sec"];
        $qtext = $_POST["quest"];
        $qnum = $_POST["q-num"];
        $reason = $_POST["reason"];
        $status = $_POST["status"];
        $res = $stat->execute([':gnum'=>$gnum, 'labSec'=>$labSec,
':qtext'=>$qtext, ':qnum'=>$qnum, ':reason'=>$reason, ':status'=>$status]);
        echo "exec'd\n";
#echo "yippee!";
        echo $res;



    } catch (PDOException $e) {
        echo "Conn Failed: ".$e->getMessage();
    }
}
#$que.print();
#.$a[0]; #.var_dump($_POST).var_dump($_REQUEST).var_dump($_GET); #"$q";
#echo $q;

?>


