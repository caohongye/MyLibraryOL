<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ReturnHistory</title>
    <style>
        table{
            border-collapse: collapse;
            border: 2px solid rgba(20,118,185,1.00);
        }
        th{
            text-align: center;
            color:rgba(91,89,89,1.00);
            font-size:180%
        }
        td{
            text-align: center;
            font-size:120%
        }
        body{
            background:url("img/p3.JPG");
            background-size: 100%;
            background-attachment: fixed;
            background-repeat:no-repeat;
            background-size: cover;
        }
        button{
            border: 3px solid rgba(25,72,154,1.00);
            border-radius: 10px;
            width: 110px;
            background-color:rgba(20,118,185,1.00);
            color:white;
        }
        a{
            text-decoration:none;
        }
        a:link{
            color: aqua;
        }
        a:hover{
            color: rgba(45,197,55,1.00);
        }
        a:active{
            color:rgba(232,26,29,1.00);
        }
        a:visited{
            color: rgba(241,16,20,1.00);
        }
        ul.upper-latin {list-style-type: upper-latin}
        .box{margin:50px;padding:40px;margin-top:30px;width:1700px;height:100%;background-color:rgba(255,255,255,0.5)}
        .itembox {padding:15px;width: 2000px}
        .itembox_left{width:1500px;display:inline-block;}
        .itembox_right{display:inline-block;}
        .item_question{padding-left: 20px;font-size:140%}
        .item_ID{text-align:center;font-size: 150%;color:red;padding-bottom: 50px}
        .item_answer{font-size:120%}
        .item_answer_option{display:inline-block;width:1250px}
        .item_answer_count{display:inline-block;width:200px}
        .item_button{color: black;text-decoration:none;font-size:120%;
            width:7em;text-decoration:none;padding:0.2em 0.6em;border-right:0px}
        .search_box{padding:20px;height:35px;background-color:rgba(255,255,255,0.7);width: 1600px;border-radius: 5px}
        .search_from{padding-left:0px;width: 1200px;}
        .search_input{width: 400px;height:25px;font-size: 16px;border-radius: 5px;border: 1px solid rgb(180, 180, 180);}
        .search_button{ text-align:center; width: 100px;height:30px;font-size: 18px;margin-left: -10px;
            letter-spacing:0.4em;border-radius: 4px;border: 1px solid rgb(180, 180, 180); }
        a:hover{color:#ff3300}
    </style>
    <!--	<script>-->
    <!--		function delete(){-->
    <!--			var x=confirm("Do you want to delete it?");-->
    <!--			if(x==true){-->
    <!--				return true;-->
    <!--			}else{-->
    <!--				return false;-->
    <!--			}-->
    <!--}-->
    <!--	</script>-->
</head>
<body>

<div>
    <form class="search_from" action="ReaderBNewHistory.php?act=seek" method="get">
            <span>
                <input class="search_input" type="text" name="bookName" placeholder="please input  key of the book that you want to check ">
                <input class="search_button" type="submit" value="search">
            </span>
    </form>
</div>
<br>

<table  style="width:1400px;height:35px" border="1">
    <thead>
    <tr>
        <th>borrowID</th>
<!--        <th>returnID</th>-->
        <th>bookID</th>
        <th>bookName</th>
        <th>readerID</th>
        <th>readerName</th>
        <th>endTime</th>
        <th>fineID</th>

        <!--        <th>Location</th>-->
        <!--        <th>Edit</th>-->
    </tr>
    <?php
    error_reporting(0);
    session_start();
    $name=$_SESSION['name'];
    $con=mysqli_connect("localhost","root","root","bibliosoft");
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"bibliosoft");

    mysqli_set_charset($con, "UTF8");
    $pagesize=6;
    $url=$_SERVER["REQUEST_URI"];
    $url=parse_url($url);
    $url=$url['path'];
    $sql="select * from returninfor,reader_table where returninfor.readerID=reader_table.readerID and reader_table.readername='$name' ";
    $query=mysqli_query($con,$sql);
    $rows=mysqli_num_rows($query);

    $sql5="select * from borrowinfor,reader_table where borrowinfor.readername=reader_table.readername and reader_table.readername='$name'";
    $query5=mysqli_query($con,$sql5);
    $row5=mysqli_num_rows($query5);

    $pageval=1;
    $page=($pageval-1)*$pagesize;
    if(!empty($_GET['page'])){
        $pageval=$_GET['page'];
        if ($pageval<=0){
            $pageval=1;
        }
        $page=($pageval-1)*$pagesize;
    }

    $sqls="select * from `borrowinfor`,`bookinfor`,`reader_table`  where borrowinfor.bookID=bookinfor.bookID and reader_table.readername='$name 'and borrowinfor.readername=reader_table.readername limit $page,$pagesize";
    $results = mysqli_query($con,$sqls);
    while($row = mysqli_fetch_array($results))
    {
        $id=$row['borrowID'];
//        if($row['isAppointed']==1)$isAppointed="yes";
//        else $isAppointed="no";
//        if($row['isBorrowed']==1)$isBorrowed="yes";
//        else $isBorrowed="no";
        echo "<tr>";
        echo "<td>" . $row['borrowID'] . "</td>";
//        echo "<td>" . $row['returnID'] . "</td>";
        echo "<td>" . $row['bookID'] . "</td>";
        echo "<td>" . $row['bookName'] . "</td>";
        echo "<td>" . $row['readerID'] . "</td>";
        echo "<td>" . $row['readerName'] . "</td>";
        echo "<td>" . $row['endTime'] . "</td>";
        echo "<td>" . $row['fineID'] . "</td>";
//        echo "<td><a href='revise.php?id=$id'>Revise</a> ";?>
        <!--        <a href="delete.php?id=--><?php //echo($id)?><!--" onclick="return delete();">Delete</a>-->
        <?php echo"</td>";
        echo "</tr>";
    }
//    echo "</thead>";
//    echo "</table>";

    $sqli="select * from `returninfor`,`bookinfor`,`reader_table`  where returninfor.bookID=bookinfor.bookID and reader_table.readername='$name '
and returninfor.readerID=reader_table.readerID limit $page,$pagesize";
    $result = mysqli_query($con,$sqli);
    while($row = mysqli_fetch_array($result))
    {
        $id=$row['borrowID'];
//        if($row['isAppointed']==1)$isAppointed="yes";
//        else $isAppointed="no";
//        if($row['isBorrowed']==1)$isBorrowed="yes";
//        else $isBorrowed="no";
        echo "<tr>";
        echo "<td>" . $row['borrowID'] . "</td>";
//        echo "<td>" . $row['returnID'] . "</td>";
        echo "<td>" . $row['bookID'] . "</td>";
        echo "<td>" . $row['bookName'] . "</td>";
        echo "<td>" . $row['readerID'] . "</td>";
        echo "<td>" . $row['readerName'] . "</td>";
        echo "<td>" . $row['returnTime'] . "</td>";
        echo "<td>" . $row['fineID'] . "</td>";
//        echo "<td><a href='revise.php?id=$id'>Revise</a> ";?>
        <!--        <a href="delete.php?id=--><?php //echo($id)?><!--" onclick="return delete();">Delete</a>-->
        <?php echo"</td>";
        echo "</tr>";
    }
    echo "</thead>";
    echo "</table>";

    mysqli_close($con);

    ?>
    <div style="margin:50px"></div>
    <style>
        .wid{
            position:relative;
            left:500px}
    </style>
    <div  class="wid"  >
        <?php
        $row2=$row5+$rows;
        echo "A total of $row2 records";
        echo "&nbsp;&nbsp";
        $pagenum=ceil($row2/$pagesize);
        echo "<a href='$url?page=1'><button type='button'>Home page</button></a>";
        echo "&nbsp;";
        //第一页的时候没有上一页\
        if ($pageval > 1) {
            $test1=$pageval -1;
            echo "<a href='$url?page=$test1'><button type='button'>Previous page</button></a>";
            echo "&nbsp;";
        }
        if ($pageval < $pagenum) {
            $test=$pageval+1;
            echo "<a href='$url?page=$test'><button type='button'>Next page</button></a>";
            echo "&nbsp;";
        }
        //尾页的时候不显示下一页
        echo "<a href='$url?page=$pagenum'><button type='button'>Tail page</button></a>";
        ?>
    </div>




</body>
</html>