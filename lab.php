
<!DOCTYPE html>
<html>
<head>
<title>CSLAB Question Queue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script
src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script
src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script
src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .question {
            background-color:azure;
            padding:15px;
            margin:15px;
        }

        
    </style>
</head>
<body>
<!--h1> hello </h1-->

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
    <a class="navbar-brand"> CSLAB </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#"> Queue </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"> Messages </a>
        </li>
        <!--li class="nav-item">
            <a class="nav-link" href="#">  </a>
        </li-->
    </ul>
</nav>

<auido id="beeper" loop>

   <src = "Beep-09.ogg" type="audio/ogg">
   Your browser doesn't support HTML5 audio.
</audio>

<div class="container-fluid" style="margin-top:80px">
    <div id="alertbox"></div> 
    <div class="row">
    <div class=col-sm-1></div>
    <div class=col-sm-11>
    <h3> Welcome to the CSLAB Question Queue!</h3>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-1 spacer"></div>
        <div class="col-sm-4 question">
            <div class="offset">
                <h4> Ask a Question!</h4>
                <form id="quest" >
                    <label for "group"> Which group are you? </label>
                    <select class="custom-select" id="group"  name="group">
                        <!-- <label for="course">Select your class:</label> -->
                        <!-- <select class="custom-select" list="sup-classes" name="course" id="course"> -->
                        

                    </select>
                    <label for "q-num"> Which Question? </label>
                    <select class="custom-select" id="q-num" name="q-num">
                    </select>

                    <label for "status"> How's It Going?</label>
                    <select class="custom-select" id="status" name="status">
                        <option id="debug" name="debug" value="Debugging Help">
                            Debugging Help</option>
                        <option id="checkout" name="checkout" 
                            value="We've Got It - Time for Checkout :)">
                            We've Got It - Time for Checkout :)
                        </option>
                        <option id="words" name="words" 
                            value="We need help understanding the lab document">
                            We need help understanding the lab document.
                        </option>
                        <option id="troubleshooting" name="troubleshooting"
                            value="Software/File system/computer issue">
                            Software/File system/computer issue
                        </option>
                        <option id="concept" name="concept" 
                            value="A concept is confusing">
                            A concept is confusing
                        </option>
                        <option id="other" name="other" value="Other">
                            Other - please explain below:
                        </option>
                    </select>
        
                </form>
                <label for "question"> Short summary of your question: </label>
                <textarea class="form-control" rows="6" id="question" name="question"></textarea>
                <br>
                <input type="hidden" name="type" id="type"
value="insert"></input>
                <button type="button" class="btn btn-success"
                    onclick="sendQuestion()">Ask Question!</button>
            </div> 
        </div>
        <style>

            .queue {
                background-color: #d9ccff;//pink;
                margin: 15px;
                padding: 15px;
            }
            .card {
                border-radius: 20px;
                background-color: #f2ffcc;//purple;
                margin-top: 10px;
                margin-bottom: 10px;
                //border: solid;
            }

            p.cname {
                text-align: center;
            }

            .card-top {
                background-color: #fff2cc;//goldenrod;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                margin-left: 0px;
                margin-right: 0px;
                margin-top: 0px;
            }
                
            .card-middle {
                padding: 10px;
            }

            h4.nums {
              //  test-align: center;
            }
        </style>
        <div class="col-sm-6 queue">
            <h4> Queue:  <span id="numQ"></span></h4>

            <div id="queue-back" class="queue-back">
            </div>
        </div>
        <div class="col-sm-1 spacer"></div>

    </div>    
</div>

<script>

    function getUUID() {
        return localStorage.getItem("uuid");
    }

    var supClasses = [
        "CS 1111 - Introduction to Programming in C/C++", "CS 1121 - Introduction to Programming I",
        "CS 1122 - Introduction to Programming II", "CS 1131 - Accelerated Introduction to Programming",
        "CS 1142 - Programming at the Hardware Software Interface", "CS 2311 - Discrete Structures",
        "CS 2321 - Data Structures"];
    var dur = 1000;

    $(document).ready(function(){
        createList();
        fetchQuestions();
        firstLoad = false;
        run = setInterval(fetchQuestions, dur);
    });

    function createGroupList() {
        $("#group").empty();
        for (var i = 1; i <= 21; i++) {
            //$("#course").empty();
            $("#group").append("<option value=\"" + i + "\">" + i + "</option>");

        }
       $("#group").append("<option value=\"-1\">Other - Please list in text area below:</option>");
    }

    function createQuestionList() {
        $("#q-num").empty();
        for (var i = 1; i <= 6; i++) {
            $("#q-num").append("<option value=\"" + i + "\">" + i +
"</option>");
        }
    }

    function createList() {
        createGroupList();
        createQuestionList();
    }

    function sendQuestion() {
        clearInterval(run);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this);
                document.getElementById("question").value = "";
                createList();
                var b = "<div class=\"alert alert-success alert-dismissible\">"
                + "<button type=\"button\" class=\"close\""
                + " data-dismiss=\"alert\"> &times;</button>"
                + "<strong>Hang On!</strong> We'll be with you soon.<br>"
                + "Meanwhile, try explaining your question to a rubber duck!"
                + "</div>";
                $("#alertbox").append(b);                      
                fetchQuestions();
                run = setInterval(fetchQuestions, dur);
            }
        };
        xhttp.open("POST", "labdb.php", true);
        xhttp.setRequestHeader("Content-type", 
          "application/x-www-form-urlencoded");
        
        localStorage.setItem("group_num", document.getElementById("group"));       
 
        var msg = "type=insert" + "&lab-sec=" + localStorage.getItem("ls") 
            + "&quest=" + document.getElementById("question").value
            + "&group=" + document.getElementById("group").value
            + "&q-num=" + document.getElementById("q-num").value
            + "&reason=" + document.getElementById("status").value
            + "&status=null";       
        xhttp.send(msg);
    }

    var firstLoad = true;
    var lastNum = 0;
    var run = setInterval(fetchQuestions(), dur);
   
    //beep(); 
    function timer(old) {
        var d = new Date();
        var n = (d - new Date(old));
        var nd = new Date(n);
        var h = nd.getHours();
        var m = nd.getMinutes();
        if (m < 10) {
            m = "0" + m;
        }
        var s = nd.getSeconds();
        if (s < 10) {
            s = "0" + s;
        }
        return (h - 19) + ":" + m + ":" + s;
    }

    var x = document.getElementById("beeper");

    function beep() {
        document.getElementById("beeper").play();
        setTimeout(pauseBeep, 1500);
    }

    function pauseBeep() {
        x.pause();
    }

    function buildList(jsone) {
        $("#queue-back").empty();//append(jsone);
        var arr = JSON.parse(jsone);
        //console.log(arr[0]);
        //console.log(arr.length);
     //   lastNum = arr[arr.length - 1]["num"];
        for (var i = 0; i < arr.length; i++) {
            var c = "<div class=\"row\">"
                + "<div class =\"col-sm-3\"><h5>" + arr[i]["num"]
                + "</div><div class=\"col-sm-9\"><p>" + arr[i]["class"]
                + "</p><br><p>" + arr[i]["quest"] + "</p></div></div>";
            var b = "<div class=\"btn btn-primary\">"
                + "<h5>" + arr[i]["num"] + "</h5><br>"
                + "<p>" + arr[i]["class"] + "</p></div>";
            var d = "<div class=\"card\">";
           
            //var elem = -1 | arr[i]["num"];
            var del = "<button class=\"btn btn-danger\""
                        + " onclick=\"delQuest(" + arr[i]["num"] 
                          + ")\" id=" + arr[i]["num"] 
                        + ">"
                    + "Del</button>";
            var canDel = false;
            if (arr[i]["group_num"] == localStorage.getItem("group_num")) {
                canDel = true;
            }
            if (localStorage.getItem("auth") == "coach") {
                canDel = true;
            }
            if (canDel == false) {
                del = "";
            }
 
            timea = timer(arr[i]["time_asked"]); 
            var loc = "<div class=\"card\"><div class=\"row card-top\">"
                    + " <div class=\"col-sm-2\"></div>"
                    + " <div class=\"col-sm-4\"><p class=\"cname\">"
                    + arr[i]["reason"] +"</p></div>"
                    + "<div class=\"col-sm-2\"><p class=\"cname\">Group "
                    + arr[i]["group_num"] + "</p></div>"
                    + "<div class=\"col-sm-2\"><p class=\"cname\">Problem "
                    + arr[i]["qnum"] + "</p></div>"
                    + "<div class=\"col-sm-2\"></div></div>"
                    + "<div class=\"row card-middle\">"
                        + "<div class=\"col-sm-2\">"
                            + "<h4 class=\"nums\">" + arr[i]["num"] + "</h4>"
                            + "<p>Wait time: " + timea + "</p>"// needs more work
                        + "</div>"
                        + "<div class=\"col-sm-8\">"
                            + arr[i]["question"] + "</div>"
                        + "<div class=\"col-sm-2\">" + del 
                      //      + "<button class=\"btn btn-danger\">Del</button>"
                        + "</div></div>"
                    + "<div class=\"row card-bottom\"></div></div>";

            if (arr[i]["num"] > lastNum && lastNum > 0) {
                // beep! 
                console.log("beep!");
                //beep();
            }

            $("#queue-back").append(loc);
        }
        if (arr.length > 0) {
            lastNum = arr[arr.length - 1]["num"];
        }
        $("#numQ").text(arr.length);
        //$("#queue-back").append(arr[0][1]);
    }

    function delQuest(a) {
        clearInterval(run);
        //console.log(a);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                fetchQuestions();
                run = setInterval(fetchQuestions, dur);
            }
        };
        xhttp.open("POST", "labdb.php", true);
        xhttp.setRequestHeader("Content-type",
            "application/x-www-form-urlencoded");
        var msg = "type=del&role="+localStorage.getItem("auth") + "&nums="
            + a;
        xhttp.send(msg);
   
    }

    var qu = 0;

    function fetchQuestions() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                /*console.log(this.responseText);
                console.log(this);
                console.log("fetched again, rover!");*/
                if(qu == 0) {
                    console.log(this);
                    qu = 1;
                }
                buildList(this.response);
            }
        };
        xhttp.open("POST", "labdb.php", true);
        xhttp.setRequestHeader("Content-type", 
          "application/x-www-form-urlencoded");
        
        var msg = "type=fetch"; "&uuid=" + 
            localStorage.getItem("uuid");
        xhttp.send(msg);

    }

    
    /*  Create a universally unique user id
     *  from:
https://www.w3resource.com/javascript-exercises/javascript-math-exercise-23.php
    */
    function create_UUID(){
        var dt = new Date().getTime();// 36 chars of uuid
        var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,
            function(c) {
                var r = (dt + Math.random()*16)%16 | 0;
                dt = Math.floor(dt/16);
                return (c=='x' ? r :(r&0x3|0x8)).toString(16);
            });
        //document.getElementById("hola").innerText = uuid;
        return uuid;
    }


    function authorize(vals, types) {

        var u = localStorage.getItem("uuid");
        if (vals == 'true') {
            localStorage.setItem("auth", types);
            if (u == null) {
                var v = create_UUID();
                localStorage.setItem("uuid", v);
            }
        } else {
        //    localStorage.setItem("who", "me");
          //  console.log("hello there! nnerHTMLd to type any text");
            var b = "<div class=\"alert alert-warning alert-dismissible\">"
                + "<button type=\"button\" class=\"close\""
                + " data-dismiss=\"alert\"> &times;</button>"
                + "<strong>Oops!</strong> You're missing part of the link!"
                + "Check your url for what comes after the '?'.<br>"
                + "You can still ask a question, but you won't be able to "
                + "type custom details into the text field (we're working on"
                + " building a better spam filter ;-) )</div>";
            $("#alertbox").append(b);        
        }
    }
</script>

<script>
    var classes = ["CS1000 - Explorations in Computing", "CS 1090 - Special Topics in Computer Science",
        "CS 1111 - Introduction to Programming in C/C++", "CS 1121 - Introduction to Programming I",
        "CS 1122 - Introduction to Programming II", "CS 1131 - Accelerated Introduction to Programming",
        "CS 1142 - Programming at the Hardware Software Interface", "CS 2311 - Discrete Structures",
        "CS 2321 - Data Structures", "CS 3000 - Ethical and Social Aspects of Computing",
        "CS 3090 - Special Topics in Computer Science", "CS 3141 - Team Software Project",
        "CS 3311 - Formal Models of Computation", "CS 3331 - Concurrent Computing",
        "CS 3411 - Systems Programming", "CS 3421 - Computer Organization",
        "CS 3425 - Introduction to Database Systems", "CS 3712 - Software Quality Assurance",
        "CS 4090 - Special Topics in Computer Science", "CS 4099 - Directed Study in Computer Science",
        "CS 4121 - Programming Languages", "CS 4130 - Compiler Design and Optimization",
        "CS 4321 - Introduction to Algorithms"];

    function setLabSec(val) {
        localStorage.setItem("ls", val);
        console.log(val);
    }


</script>

<?php

    $key = $_GET['music'];
    $labs = $_GET['ls'];
    #echo "labs: $labs"; 
    #echo $key;
    echo "<script> setLabSec($labs);</script>";
    #echo "<script> localStorage.setItem(\"ls\", $_GET['ls']); </script>";
    if (strcmp($key, "oboe") == 0) {
       # echo "<h2>yippee</h2>";
        echo "<script>authorize('true', 'student');</script>";
    } else if (strcmp($_GET["ilove"], "programming") == 0) {
        echo "<script>authorize('true', 'coach');</script>";
    } else {
       # echo "<h3>unauthorized</h3>";
        echo "<script>authorize('false', null);</script>";
    }


?>



</body>
</html>
