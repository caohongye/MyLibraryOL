<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>EditBooks</title>
<style>
	table{
		border-collapse: collapse;
		border: 2px solid rgba(20,118,185,1.00);
	}
	th{
        text-align: center;
		color:rgba(91,89,89,1.00);
        font-size:180%;
    }
    td{
        text-align: center;
        font-size:120%;
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
</style>
	</head>
<body>
	<?php
	$book=$_GET['infor'];
	if(empty($book)){
		die('Please input the id of the book.');
	}
	?>
	<table  style="width:1400px;height:35px" border="1px">
            <thead>
            <tr>
        <th>ID</th>
        <th>bookID</th>
        <th>bookName</th>
        <th>readerID</th>
        <th>startTime</th>
        <th>endTime</th>
        <th>isBack</th>
        <th>fineID</th>
        <th>debtDays</th>
				<th>LOST</th>
            </tr>
            <?php
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
            $sql="select * from borrowinfor,bookinfor where borrowinfor.bookID=bookinfor.bookID and (borrowinfor.bookID='$book' or borrowinfor.readerName='$book')";
//            echo $sql;
            $query=mysqli_query($con,$sql);
            $rows=mysqli_num_rows($query);
            $pageval=1;
            $page=($pageval-1)*$pagesize;
            if(!empty($_GET['page'])){
                $pageval=$_GET['page'];
                if ($pageval<=0){
                    $pageval=1;
                }
                $page=($pageval-1)*$pagesize;
            }
            $sqli="select * from borrowinfor,bookinfor where borrowinfor.bookID=bookinfor.bookID and (borrowinfor.bookID='$book' or borrowinfor.readerName='$book') limit $page,$pagesize";
            $result=mysqli_query($con,$sqli);
            while($row=mysqli_fetch_array($result))
            {
				$id=$row['fineID'];
                echo "<tr>";
        echo "<td>" . $row['borrowID'] . "</td>";
        echo "<td>" . $row['bookID'] . "</td>";
        echo "<td>" . $row['bookName'] . "</td>";
        echo "<td>" . $row['readerName'] . "</td>";
        echo "<td>" . $row['startTime'] . "</td>";
        echo "<td>" . $row['endTime'] . "</td>";
        echo "<td>" . $row['isBack'] . "</td>";
        echo "<td>" . $row['fineID'] . "</td>";
        echo "<td>" . $row['debtDays'] . "</td>";
				echo "<td><a href='lib_book_lost.php?bookid=$book&fineid=$id'>lost</a> ";
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
                echo "A total of $rows records";
				echo "&nbsp;&nbsp";
                $pagenum=ceil($rows/$pagesize);
                echo "<a href='$url?page=1&infor=$book'><button type='button'>Home page</button></a>";
                echo "&nbsp;";
                //第一页的时候没有上一页\
                if ($pageval > 1) {
                $test1=$pageval -1;
                echo "<a href='$url?page=$test1&infor=$book'><button type='button'>Previous page</button></a>";
                echo "&nbsp;";
                }
                if ($pageval < $pagenum) {
                $test=$pageval+1;
                echo "<a href='$url?page=$test&infor=$book'><button type='button'>Next page</button></a>";
                echo "&nbsp;";
                }
                //尾页的时候不显示下一页
                echo "<a href='$url?page=$pagenum&infor=$book'><button type='button'>Tail page</button></a>";
                ?>

            </div>
</body>
</html>