<!--Php is sort of like a macro, defining a macro variable using a $. 
And then echo, substituting a variable name by its definition. -->
<?php
// Create Database connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Check Database connection, if there is error then echo failure message
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
	//if(isset($_POST['name'])) {
	     
	     //$UNAME = ($_POST['name']);
		 //$GREETING = 'Thank you '. $UNAME.'.';

		 //} else { 
		 //$GREETING = 'Welcome Guest. <a href="#" class="my_popup_open">Log on</a> for recommendations.'; 
		 //}
		 //$CARTCOUNT = 0;
		 
// If $_POST['name'] has been assigned, then do the following.
		 
	if(isset($_POST['name'])) {
	
//MIDTERM ADDITIONS - EXPERT TIP - AVOID POSTING LOOP
// If $_POST['cookie'] has been assigned, then update $COOKIELOAD status
	 if(isset($_POST['cookie'])) {
	  $COOKIELOAD=1; }
	  
	    //Define new variables for later use.
		 $CARTCOUNT = 0;
	     $UNAME = ($_POST['name']);
		 $GREETING = 'Welcome back '. $UNAME.'.';
		 
	//MIDTERM ADDITIONS - SQL SELECT TO GET USER DETAILS
    //Select a row in the customer database to match with logged in user name and push each column value to newly defined variable	
		 $search1 = mysqli_query($con,"SELECT * FROM `Customer` WHERE FIRST = '". $UNAME ."'");
	//If visiting user name matches that in the database then do. 
		 if(mysqli_num_rows($search1) > 0){
		 //Fetch key column values to assign to newly defined variables.
		 while($row = mysqli_fetch_array($search1)) {
		  $CARTCOUNT = $row[CartItems];
		  $PREF = $row[Pref];
		  $LATEST = $row[LastCart];
		  }
		  
	//MIDTERM ADDITIONS - LOGIC TO SET BOOKS
	      //Select a row in bookdetails database by $PREF
	      $search2 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE CatID = '". $PREF ."'");
		  
		  //If there is an item in shopping cart, then put its info in the first position.
		  if($LATEST != 0) {
		   $n=2;
		   $search3 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid = '". $LATEST ."'");
	       $BOOKID1=$LATEST;
		   //Loop to get the shopping cart item info and push them into variables for later reference.
		   while($row = mysqli_fetch_array($search3)) {
		   ${"BOOKPIC1"} = $row[Image];
		   ${"BOOKTITLE1"} = $row[Title];
		   ${"BOOKAUTH1"} = $row[Author];
		   ${"BOOKDESC1"} = $row[Description];
		   ${"BOOKPRICE1"} = $row[Price];
		   }
		  } 
		  //If there is no shopping cart item, then use $n and loop to get books info of preference.
		  else 
		  { $n=1; 
		  }
		  while($row = mysqli_fetch_array($search2)) {
		  if($row[bid] != $LATEST){
	       ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];
		   $n++;
		   }
		    }
		   } 
		   //If visiting user name does not match any of those in the customer database, then show default (or most popular books in the future) books.
		   else {
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
      }
     }	 
	 
	 //If the visiting customer has not logged in, then show guest greetings and default books.
	 else { 
		 $GREETING = 'Welcome Guest. <a href="#" class="my_popup_open">Log on</a> for recommendations.';
	//MIDTERM ADDITIONS - SET BOOKS FOR LOGGED OUT VISITORS
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

		 }		 
?>

<html>

<!--Head sets up the rules -->
 <head>

<!--Indicating usage of outer script source --> 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://www.imcanalytics.com/js/jquery.popupoverlay.js"></script>
 
 <!--In-line CSS, defining the format structure of the entire page -->
 <style>
 section {
    width: 80%;
    height: 200px;
    margin: auto;
    padding: 10px;
}

#one {
  float:left; 
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:170px;
}

#two { 
  overflow:hidden;
  width:40%;
  border:1px solid;
  min-height:170px;
}

#three {
  float:left; 
  margin-top:10px;
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:170px;
}

#four { 
  overflow:hidden;
  margin-top:10px;
  width:40%;
  border:1px solid;
  min-height:170px;
}

@media screen and (max-width: 400px) {
   #one { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #two { 
  background-color: white;
  overflow:hidden;
  width:auto;
  margin-bottom:10px;
  min-height:170px;
}

   #three { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #four { 
  background-color: white;
  overflow:hidden;
  width:auto;
  min-height:170px;
}

}
</style>

<script>
// This is a popup function    
    $(document).ready(function() {

      // Initialize the plugin
	 
      $('#my_popup').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });

//ASSIGNMENT TWO ADDITIONS - ADDED A SECOND POP-UP FUNCTION 

      $('#bookdeets').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });
   
});

//ASSIGNMENT TWO ADDITIONS - ADDED THIS JQUERY FUNCTION

   $.fn.DeetsBox = function(bid) {
        if(bid == '1'){
	//MIDTERM ADDITIONS - NEW VARIABLES AND CONDITIONS
	//Make the info in the first section dynamically change 
		var bookname = $( "#book1" ).val();
		var bookprice = $( "#book1price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); 
		$("#bookshelf").val('1'); 
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); }
		}
		else if(bid == '2'){
		$("#showbookdeets").html("A Perfect Vacuum<p>$9.99"); 
		$("#bookshelf").val('2'); 	
		}
		else if(bid == '3'){
		$("#showbookdeets").html("White Teeth<p>$29.99"); 
		$("#bookshelf").val('3'); 		
		}
		else if(bid == '4'){
		$("#showbookdeets").html("The First 15 Lives of Harry August<p>$39.99"); 
		$("#bookshelf").val('4'); 		
		}
		
		$('#bookdeets').popup('show');
    };

</script>


<!--Using JavaScript to write cookie -->
<script language="JavaScript">

//TWO FUNCTIONS TO SET THE COOKIE

function mixCookie() {

 	    var name = document.forms["form1"]["name"].value;//Get "name" from form "my_popup"
        
		//Invoking the bakeCookie function defined below
        bakeCookie("readuser", name, 365);
			
   }
 
//Set cookie's name, value and expire date etc. and save them to document.cookie
function bakeCookie(cname, cvalue1, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));//millisecond 
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue1 + ";" + expires;//write to cookie
}

//TWO FUNCTIONS TO GET THE COOKIE

function checkCookie() {

    var userdeets = getCookie("readuser");//Invoke "getCookie" function that returns either value of user's input or ""
    
	//MIDTERM ADDITIONS - 'CHECKFIRST' VARIABLE - FOR 'IF' BELOW
	var checkfirst = document.getElementById('firstload').value;
	
	if (userdeets != "") {
	    var deets = userdeets.split("%-");//Is this necessary here in this case?
		var user = deets[0];//Assign user's input to variable "user"
		
		//MIDTERM ADDITIONS - NEW NESTED 'IF' LOGIC TO POST USERNAME TO PHP TO CHECK FOR DETAILS THROUGH SQL		
		 if(checkfirst != 1){
		  
		  post('index.php',{name:user,cookie:yes});
		  
		 } else { greeting.innerHTML = 'Welcome ' + user; }//Modify "greeting" division to show that user has been recognized
	} else { return "";//If "getCookie" function returns "", then "checkCookie" returns "", too
  }
}

//Get cookie from document.cookie
function getCookie(cname) {

    var name = cname + "="; //cookie name
    var ca = document.cookie.split(';'); //split cookie by semicolon and store them to array ca[i]
    for(var i=0; i<ca.length; i++) {  //loop to get i elements of ca
        var c = ca[i].trim();//trim white blanks
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);//if find the cookie name at position 0 then return the value of the cookie name
    }
    return ""; //else return missing
}

<!--MIDTERM ADDITIONS - FUNCTION TO DELETE COOKIE -->
//Set the expiration date to an earlier date to make the cookie expired and hence gets deleted.
function drop_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  window.location.href = window.location.pathname;
}

<!--MIDTERM ADDITIONS - FUNCTION TO POST FROM JS -->
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
</script>

<!--GOOGLE ANALYTICS CODE WILL GO HERE -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61581655-2', 'auto');
  ga('send', 'pageview');

</script>

 </head>
 <!--head part ends -->
 
 <!--body part begins, loading "checkCookie" function defined above -->
 <body onload="checkCookie()">
 
 <!--The top bar division, format in "style" and image source in "img" -->
 <div style="width:100%; height:25%; background-color:#57585A;">
 <img src="img/ic1.jpg" style="max-height: 100%;">
 
 <!--MIDTERM ADDITIONS - LOG-OUT LINK & LOGIC FOR VISITOR LOGGED STATE. CART NOW A LINK.--> 
<?php if(isset($_POST['name'])) { ?>
    <div style="float:right; margin-right:50px;margin-top:10px; color:white;"> <a href="#" style="color:white;" onclick="drop_cookie('readuser');">Log Out</a> </div>
	
	<div style="float:right; margin-right:75px;margin-top:10px; color:white;"> 
	 <a href="#" style="color:white;" >Cart: <?php echo $CARTCOUNT ?></a>
	 </div>
 <?php } ?>
 </div>
 
 <!--Topic division -->
 <div style="margin-top:10px; margin-bottom:10px; font-size: 130%; color:#57585A;">
 <strong>Icculus Media: For All Your Fictional Needs</strong>
 </div>
 
 <!--Greeting division, php variable echoed, id assigned ready to be recalled -->
 <div id="greeting"> <?php echo $GREETING ?> </div>
 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED IN NEW CHECKCOOKIE LOGIC -->
 <input type="hidden" id="firstload" value="<?php echo $COOKIELOAD ?>">
 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED FOR BOOK1 CTA -->
 <input type="hidden" id="iscart" value="<?php echo $LATEST ?>">
 
 <!--Browse division, id assigned ready to be recalled  -->
 <div id="cta1"> Please browse our options:</div>
 <!--
 <!--Images and paragraphs(contents, formats, source, fonts) within the four boxes -->
 <section>
    <div id="one" style="padding:10px;">
	<img src="img/Borges.jpg" style="float:left; margin-right:6px; height: 100px;">
	
	<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
    <input type="hidden" id="book1" value="Labyrinths">
	<strong>Labyrinths</strong><p>
	by Jorge Luis Borges<p>
	If Jorge Luis Borges had been a computer scientist, he probably would have invented hypertext and the World Wide Web. 
	Instead, being a librarian and one of the world's most widely read people, he became the leading practitioner of a densely 
	layered imaginistic writing style that has been imitated throughout this century, but has no peer. 
	
	<!-- ASSIGNMENT 2 ADDITIONS - MOVED '/div' STATEMENT DOWN. ADDED 'LEARN MORE' CTA BUTTON WITH GA 'SEND EVENT' AND POP-UP FUNCTION CALLS ONCLICK -->
	
	<p>
	<input type="button" value="Learn More" id="book1button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book1').value); $(this).DeetsBox(1);">
	</div>
    
	<div id="two" style="padding:10px;">
	<img src="img/Lem.jpg" style="float:left; margin-right:6px; height: 100px;">
	
	<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
    <input type="hidden" id="book2" value="A Perfect Vacuum">
	<strong>A Perfect Vacuum</strong><p>
	by Stanislaw Lem<p>
	In A Perfect Vacuum, Stanislaw Lem presents a collection of book reviews of nonexistent works of literature. Embracing 
	postmodernism's "games for games' sake" ethos, Lem joins the contest with hilarious and grotesque results, lampooning 
	the movement's self-indulgence and exploiting its mannerisms.
	
	<!-- ASSIGNMENT 2 ADDITIONS - MOVED '/div' STATEMENT DOWN. ADDED 'LEARN MORE' CTA BUTTON WITH GA 'SEND EVENT' AND POP-UP FUNCTION CALLS ONCLICK -->	
	<p>
	<input type="button" value="Learn More" id="book2button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book2').value); $(this).DeetsBox(2);">
	</div>
	
	<div id="three" style="padding:10px;">
	<img src="img/Zsmith.jpg" style="float:left; margin-right:6px; height: 100px;">
	
	<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
    <input type="hidden" id="book3" value="White">
	
	<strong>White Teeth</strong><p>
	by Zadie Smith<p>
	Epic and intimate, hilarious and poignant, White Teeth is the story of two North London families - one headed by Archie, 
	the other by Archie's best friend, a Muslim Bengali named Samad Iqbal. Pals since they served together in World War II, 
	Archie and Samad are a decidedly unlikely pair. 
	
	<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
	<p>
	<input type="button" value="Learn More" id="book3button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book3').value); $(this).DeetsBox(3);">
	</div>
    
	<div id="four" style="padding:10px;">
	<img src="img/North.jpg" style="float:left; margin-right:6px; height: 100px;">
	
	<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
    <input type="hidden" id="book4" value="August">
	
	<strong>The First 15 Lives of Harry August</strong><p>
	by Claire North<p>
	Harry August is on his deathbed--again. No matter what he does or the decisions he makes, when death comes, Harry always 
	returns to where he began, a child with all the knowledge of a life he has already lived a dozen times before. Nothing ever
	changes--until now. 
	
		<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
	<p>
	<input type="button" value="Learn More" id="book4button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book4').value); $(this).DeetsBox(4);">
	</div>
	
</section>

<!--Using a form as a pop-up window to interact with users and to give input to the cookie -->
	<div id="my_popup" style = "background-color: white; display: none; padding: 20px;">
    <form name="form1" action="#" method="post">
	     <div>Please enter your name:</div>
		 
	<!--Text input -->
    <input name="name" id="uname" type="text" /><p>
	
	<!--The "log in" button and recall the set cookie function "mixCookie()" when click -->
	<input type="submit" onclick="mixCookie();ga('send', 'event', 'registration', 'logon', document.getElementById('uname').value)" value="Log In"/> <p>
	</form>
	</div>
	
<!-- ASSIGNMENT 2 ADDITIONS - ADDED THIS 'LEARN MORE' POPUP -->	

	<div id="bookdeets" style = "background-color: white; display: none; padding: 20px;">
   
<!--    <form name="grapefruit" action="#" method="post">
	<div id="showbookdeets"></div>
    <input type="hidden" id="bookshelf"  value="0">
	<input type="submit" value="Add to Cart" onClick="ga('send', 'event', 'convert', 'cart_add', document.getElementById('bookshelf').value)";/> <p>
	</form>
	
	</div>
-->

    <div id="showbookdeets"></div>
    <input type="hidden" id="bookshelf"  value="0">
	
<!--MIDTERM ADDITIONS - CHANGED TO BUTTON TO CLOSE-->

	<button id="deetcta" class="bookdeets_close"  onClick="ga('send', 'event', 'convert', 'cart_add', document.getElementById('bookshelf').value)";/>Add to Cart</button> <p>
	</div>
	
 </body>
 </html>