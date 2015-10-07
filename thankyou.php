<?php
//MIDTERM ADDITIONS - DATABASE CONNECTION
// Create Database connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Check Database connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

		  $n=1;
		  $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
           while($row = mysqli_fetch_array($search4)) {
		   ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];	
           $n++;
		   }		   

?>

<html>

 <head>

 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://www.imcanalytics.com/js/jquery.popupoverlay.js"></script>
 <style>
 section {
    width: 90%;
    height: 200px;
    margin: auto;
    padding: 10px;
}

#one {
  margin-right:20px;
  width:90%;
  background-color: #f5f5dc;
  min-height:110px;
}
#two {
  margin-right:20px;
  width:90%;
  background-color: #eaf0f4;
  min-height:200px;
}

@media screen and (max-width: 400px) {
   #one { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }

}
</style>

<script language="JavaScript">

//TWO FUNCTIONS TO GET THE COOKIE

function checkCookie() {
    var userdeets = getCookie("readuser");
    if (userdeets != "") {
	    var deets = userdeets.split("%-");
		var user = deets[0];
		//greeting.innerHTML = 'Welcome ' + user + '.'; 
		} else { return "";}
}

function getCookie(cname) {

    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

<!--MIDTERM ADDITIONS - FUNCTION TO DELETE COOKIE -->

function drop_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  window.location.href = window.location.pathname;
}

</script>

<!--GOOGLE ANALYTICS CODE -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61581655-2', 'auto');
  ga('send', 'pageview');

</script>

 </head>
 
 
 <body  onload="checkCookie()">

 
 <div style="width:100%; height:25%; background-color:#57585A;">
 <!--TESTING PROJECT ADDITION - IMAGE TO HOME -->
 <a href="index.php">
 <img src="img/ic1.jpg" style="max-height: 100%;">
 </a>
 
<!--MIDTERM ADDITIONS - LOG-OUT LINK & LOGIC FOR VISITOR LOGGED STATE. CART NOW A LINK.--> 

    <div style="float:right; margin-right:50px;margin-top:10px; color:white;"> <a href="index.php" style="color:white;" onclick="ga('send','event','log_out','log_out',getCookie('readuser'));drop_cookie('readuser')" >Log Out</a> </div>

 <div style="margin-top:10px; margin-bottom:10px; font-size: 130%; color:#57585A;">
 <strong>Icculus Media: For All Your Fictional Needs</strong>
 </div>
 

 <section>
 <div id="one" style="padding:10px;">
    Thank you for choosing to read Icculus!<p>
	Have a nice day.
	</div>


 </body>
 </html>
