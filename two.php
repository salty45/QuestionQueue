<?php

#$que = new Question();
$a = array();
$i = 0;
$q = $_POST["buzz"];
#$que.add_item($q);
$a[$i] = $q;
$i = $i + 1;
#$ab = var_dump($_POST);
#echo "apples:";
#foreach ($a as $p) {
 #   echo $p;
#}
##echo phpinfo();
#$mysqli = new mysqli("localhost", "a", "abc", "db");
#if ($mysqli -> connect_errno) {
 #   echo "nope!";
  #  exit();
#}

#$ver = SQLite3::version();
#echo $ver['versionString']."ap";
#var_dump($ver);
try {
   # echo "creating database";
   $conn = new \PDO('sqlite:/local/my_web_files/selarkin/ideas/test.db', null, null, 
        array(PDO::ATTR_PERSISTENT=>true));
    if ($conn == NULL) {
     #   echo "failed";
    } else {
      #  echo "...success\n";
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "attribute set\n";
    #$conn->exec("INSERT INTO TestTab VALUES (2, 'ab', 1)");
    #echo "success!";
    #$stat = $conn->prepare('SELECT * FROM TestTab');
    #echo "prepared...\n";
    #echo $stat;
    $vals = [];
    #$res = $stat->execute();
    #echo "exec'd\n";
    #echo "yippee!";
    #echo $res;
    $stat = $conn->query('SELECT * FROM TestTab');
    #$res = $stat->fetch(\PDO::FETCH_ASSOC);
    #echo $res;
    $p = 1;
    $c = 0;
    #$v = [][];
    $v = array();
    #echo "\n<br>";
    while ($row = $stat->fetch(\PDO::FETCH_ASSOC)) {
     #  echo $row;
      #  $d = json_encode($row);
        #echo $d;
       # echo " ".$p.":  [";
        #$p = $p + 1;
        #echo $row['num']."  | ";
        #echo $row['quest']."  | ";
        #echo $row['del']."]  ";
        #echo $d." \n<br>";
        #$v[$c][0] = $row['num'];
        #$v[$c][1] = $row['quest'];
        $c++;
        $vals[] = $row;
        #vals[] = $row;
    }
    echo json_encode($vals);


    
} catch (PDOException $e) {
    echo "Conn Failed: ".$e->getMessage();
}

#$que.print();
#.$a[0]; #.var_dump($_POST).var_dump($_REQUEST).var_dump($_GET); #"$q";
#echo $q;

?>


