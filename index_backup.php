<!--We are using variables, arrays, control flows and built-in functions in php to connect database with web page here.-->
<?php
// Create Database connection and assign database matrix to $con.
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Create php variables that have special offer value and are tagged.
$special1 = '<a href="#" onclick="ga(\'send\', \'event\', \'Special Offer\', \'Click SO1\', document.getElementById(\'uname\').value)">Special Book!(tagged)</a>';
$special2 = '<a href="#" onclick="ga(\'send\', \'event\', \'Special Offer\', \'Click SO2\', document.getElementById(\'uname\').value)">Free Shipping! Surprise!(tagged)</a>';
$special3 = '<a href="#" onclick="ga(\'send\', \'event\', \'Special Offer\', \'Click SO3\', document.getElementById(\'uname\').value)">Buy one & get the other at half price!!!(tagged)</a>';


// Check Database connection, if there is error then echo failure message.
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

// Control flow: if the cookie 'name' has an value as true, then do:
if(isset($_POST['name'])) {
	
     //MIDTERM ADDITIONS - EXPERT TIP - AVOID POSTING LOOP
     // Control flow: if $_POST['cookie'] has been assigned a value as true, then update $COOKIELOAD status
	 if(isset($_POST['cookie'])) {
	  $COOKIELOAD=1; }
	  
	 //Define new variables for further use.
		$CARTCOUNT = 0;
		$UNAME = ($_POST['name']);
		$GREETING = 'Welcome back '. $UNAME.'.'; 
		 
	//MIDTERM ADDITIONS - SQL SELECT TO GET USER DETAILS
    //Select and return a row in the customer database that matches with visiting user name and push each column value to newly defined variable	
	$search1 = mysqli_query($con,"SELECT * FROM `Customer` WHERE FIRST = '". $UNAME ."'");
	
	// Control flow: if visiting user name matches that in the database then do:
	// Pull in all the variables from the dataset
		if(mysqli_num_rows($search1) > 0){
		    //Fetch certain column(array) values to assign to newly defined variables.
		    while($row = mysqli_fetch_array($search1)) {
		     $CARTCOUNT = $row[CartItems];
		     $PREF = $row[Pref];
		     $LATEST = $row[LastCart];
		     $SCORE = $row[Score];
		  	 $VD = $row[VisitDays];
			 $PurchaseNum = $row[PurchNum];
			 $PurchaseTot = $row[PurchTot];
			 $PurchaseDays = $row[Purchdays];
			 $MYSCORE = $PurchaseTot;
			 
		    }
		  
	        //MIDTERM ADDITIONS - LOGIC TO SET BOOKS
	        //Select a row in bookdetails database by $PREF of the visiting user.
	        $search2 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE CatID = '". $PREF ."'");
		  
		    //Control flow: if there is an item in shopping cart, then put its info in the first position.
		    if($LATEST != 0) {
		      $n=2;
			  //Select a row in bookdetails database by $LATEST of the visiting user.
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
		    // Control flow: if there is no shopping cart item, then use $n from 1 and loop to get books info of preference.
		    else{
		      $n=1; 
		    }
			//Loop to get the user preferred books info and push them into variables for later reference.
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
		 //If visiting user name does not match any of those in the customer database, then show default books (or most popular books in the future).
		else {
		     $n=1;
			 //Select default books info.
		     $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
			//Loop to get the default books info and push them into variables for later reference.
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
 <head>

<!--Indicating usage of outer javascript source --> 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://www.imcanalytics.com/js/jquery.popupoverlay.js"></script>
 
 <!--In-line CSS, defining structure and format of the entire page -->
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
         }
		);
        //ASSIGNMENT TWO ADDITIONS - ADDED A SECOND POP-UP FUNCTION 
        $('#bookdeets').popup({  
	      transition: 'all 0.3s',
          scrolllock: true // optional
		   }
		);
    });

//ASSIGNMENT TWO ADDITIONS - ADDED THIS JQUERY FUNCTION
//Use JQUERY to dynamically show the popup info
   $.fn.DeetsBox = function(bid) {
	    // Control flow, dynamic book info the first section:
        if(bid == '1'){
	     //MIDTERM ADDITIONS - NEW VARIABLES AND CONDITIONS	     
		 var bookname = $( "#book1" ).val();
		 var bookprice = $( "#book1price" ).val();
		 $("#showbookdeets").html(bookname + "<p>" + bookprice); 
		 $("#bookshelf").val('1'); 
		 $("#deetcta").text('Add to cart');
		 var fromcart = $( "#iscart" ).val();
		    //Control flow: change button text from 'Add to cart' to 'Purchase' if there is an item in shopping cart
			//There is a bug here: once the text  'Add to cart' is replaced by 'Purchase' in deetcta, 
			//it will stay as 'Purchase' even when user clicks 'Learn More' at other sections other than the 'Purchase' button at the first section
			//Fixed by initialize text in deetcta every time invoked
		    if(fromcart != 0){
		     $("#deetcta").text('Purchase'); 
			}
		}
		// Control flow, dynamic book info the second section:
		else if(bid == '2'){
		  var bookname = $( "#book2" ).val();
		  var bookprice = $( "#book2price" ).val();
		  $("#showbookdeets").html(bookname + "<p>" + bookprice); 
		  $("#bookshelf").val('2'); 
          $("#deetcta").text('Add to cart');		  
		}
		// Control flow, dynamic book info the third section:
		else if(bid == '3'){
		  var bookname = $( "#book3" ).val();
		  var bookprice = $( "#book3price" ).val();
		  $("#showbookdeets").html(bookname + "<p>" + bookprice); 
		  $("#bookshelf").val('3'); 	
		$("#deetcta").text('Add to cart');}
		
		// Control flow, dynamic book info the fourth section:
		else if(bid == '4'){
		  var bookname = $( "#book4" ).val();
		  var bookprice = $( "#book4price" ).val();
		  $("#showbookdeets").html(bookname + "<p>" + bookprice); 
		  $("#bookshelf").val('4'); 
          $("#deetcta").text('Add to cart');		  
		}		
		$('#bookdeets').popup('show');
    };

</script>

<!--Using JavaScript to write cookie -->
<script language="JavaScript">

//TWO FUNCTIONS TO SET THE COOKIE
function mixCookie() {
				var name = document.forms["form1"]["name"].value;//Get "name" from form "my_popup" 	 
				var pref = document.getElementById('upref').value;// To get the $PREF, use hidden field <input type = hidden id = 11 value = $PREF>. Then,   
			//Invoking the bakeCookie function defined below
				bakeCookie("readuser", name, pref, 365);
    }
// One more mixcookie fucntion to get user preference 
function mixCookie1() { 
				var checkfirst = document.getElementById('firstload').value;
				var userdeets = getCookie("readuser");
				if (userdeets != "") {
					var deets = userdeets.split("%-");
					var user = deets[0];
				}
				if(checkfirst){					
					var name1 = deets[0];
					var pref1 = document.getElementById('upref').value;
					//Invoking the bakeCookie function defined below
					bakeCookie("readuser", name1, pref1, 365);
				}
    } 
 
//Set cookie's name, value and expire date etc. and save them to document.cookie
function bakeCookie(cname, cvalue1, cvalue2, exdays) {
     var d = new Date();
     d.setTime(d.getTime() + (exdays*24*60*60*1000));//millisecond 
     var expires = "expires="+d.toGMTString();//set expiration date
     document.cookie = cname + "=" + cvalue1 + "%-" + cvalue2 +'%-'+ ";" + expires;//write to cookie
    }

//TWO FUNCTIONS TO GET THE COOKIE
function checkCookie() {
     var userdeets = getCookie("readuser");//Invoke "getCookie" function that returns either value of user's input or ""
    
	 //MIDTERM ADDITIONS - 'CHECKFIRST' VARIABLE - FOR 'IF' BELOW
	 var checkfirst = document.getElementById('firstload').value;
	
	if (userdeets != "") {
	    var deets = userdeets.split("%-");
		var user = deets[0];//Assign user's input to variable "user"
		var prefer = deets[1];
		
		//MIDTERM ADDITIONS - NEW NESTED 'IF' LOGIC TO POST USERNAME TO PHP TO CHECK FOR DETAILS THROUGH SQL		
		 if(checkfirst != 1){
		  post('index.php',{name:user,cookie:'yes'});
		} 
		else{greeting.innerHTML = 'Welcome ' + user;}//Modify "greeting" division to show that user has been recognized
	} 
	else { return "";//If "getCookie" function returns "", then "checkCookie" returns "", too
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
 <body onload="checkCookie(); mixCookie1()">
 <!--The top bar division, format in "style" and image source in "img" -->
 <div style="width:100%; height:25%; background-color:#57585A;">
 <img src="img/ic1.jpg" style="max-height: 100%;">

 <!--MIDTERM ADDITIONS - LOG-OUT LINK & LOGIC FOR VISITOR LOGGED STATE. CART NOW IS A LINK.--> 
<?php if(isset($_POST['name'])) { ?>
     <!--Realize log out by drop cookie function and tag log out action-->
     <div style="float:right; margin-right:50px;margin-top:10px; color:white;"> 
	 <a href="#" style="color:white;" onclick="drop_cookie('readuser');ga('send', 'event', 'Log_out', 'log_out', document.getElementById('uname').value)">Log Out</a> </div>
	 <!--Update cart count and tag click cart action-->
	 <div style="float:right; margin-right:75px;margin-top:10px; color:white;"> 
	 <a href="cart.php" style="color:white;" onClick="ga('send', 'event', 'convert', 'cart_check', document.getElementById('uname').value)">Cart: <?php echo $CARTCOUNT ?></a>
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
 
 <!--FINAL ADDITIONS - NEW HIDDEN FIELD - USED TO GET USER PREFERENCE -->
 <input type="hidden" id="upref" value="<?php echo $PREF ?>">
 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED FOR BOOK1 CTA -->
 <input type="hidden" id="iscart" value="<?php echo $LATEST ?>">
 
 <!--Browse division, id assigned ready to be recalled  -->
 <div id="cta1"> Please browse our options:</div>
 
 <!--Dynamic images and paragraphs(contents, formats, source, fonts) within the four boxes -->
 <section>
 <div id="one" style="padding:10px;">
	<?php echo $BOOKID1; ?><!--Is this line necessary here? From UX point of view, user does not need to see this. -->
	<img src="img/<?php echo $BOOKPIC1 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC -->
    <input type="hidden" id="book1" value="<?php echo $BOOKTITLE1 ?>">
	<input type="hidden" id="book1price" value="<?php echo $BOOKPRICE1 ?>">
	<input type="hidden" id="firstload" value="<?php echo $COOKIELOAD ?>">

 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED FOR BOOK1 CTA -->
 <input type="hidden" id="iscart" value="<?php echo $LATEST ?>">
	<strong><?php echo $BOOKTITLE1 ?></strong><p>
	by <?php echo $BOOKAUTH1 ?> <p>
	<?php echo $BOOKDESC1 ?>
	<p>
	<?php if($LATEST != 0){ ?>
	<!-- Tag Purchase action -->
	<a href="cart.php"><input type="button" value="Purchase" id="book1button" onClick="ga('send', 'event', 'convert', 'Purchase', document.getElementById('book1').value)">
	</a>
	<?php } else { ?>
	<!-- Tag Learn More action -->
	<input type="button" value="Learn More" id="book1button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book1').value); $(this).DeetsBox('1')">
	<?php } ?>
	</div>
	

 <div id="two" style="padding:10px;">
	<?php echo $BOOKID2; ?>
	<img src="img/<?php echo $BOOKPIC2 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC -->
    <input type="hidden" id="book2" value="<?php echo $BOOKTITLE2 ?>">
	<input type="hidden" id="book2price" value="<?php echo $BOOKPRICE2 ?>">
	
	<strong><?php echo $BOOKTITLE2 ?></strong><p>
	by <?php echo $BOOKAUTH2 ?><p>
	<?php echo $BOOKDESC2 ?>
	<p>
	<!-- Tag Learn More action -->
	<input type="button" value="Learn More" id="book2button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book2').value);$(this).DeetsBox('2')">
	</div>
	
 <div id="three" style="padding:10px;">
	<?php echo $BOOKID3; ?>
	<img src="img/<?php echo $BOOKPIC3 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC -->
    <input type="hidden" id="book3" value="<?php echo $BOOKTITLE3 ?>">
	<input type="hidden" id="book3price" value="<?php echo $BOOKPRICE3 ?>">
	
	<strong><?php echo $BOOKTITLE3 ?></strong><p>
	by <?php echo $BOOKAUTH3 ?><p>
	<?php echo $BOOKDESC3 ?>
	<p>
	<!-- Tag Learn More action -->
	<input type="button" value="Learn More" id="book3button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book3').value);$(this).DeetsBox('3')">
	</div>
    
<!-- MIDTERM ADDITIONS - PHP SO THAT DISPLAY DEPENDS ON CART OR NOT -->	
<?php 
if($n > 4){ ?>
 <div id="four" style="padding:10px;">
	<?php echo $BOOKID4; ?>
	<img src="img/<?php echo $BOOKPIC4 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC -->
    <input type="hidden" id="book4" value="<?php echo $BOOKTITLE4 ?>">
	<input type="hidden" id="book4price" value="<?php echo $BOOKPRICE4 ?>">
	
<!-- ASSIGNMENT 2 ADDITIONS - CREATED hidden input WITH UNIQUE ID -->
	<strong><?php echo $BOOKTITLE4 ?></strong><p>
	by <?php echo $BOOKAUTH4 ?><p>
	<?php echo $BOOKDESC4 ?>
	<p>
	<!-- Tag Learn More action -->
	<input type="button" value="Learn More" id="book4button" onClick="ga('send', 'event', 'browse', 'learn_more_home', document.getElementById('book4').value);$(this).DeetsBox('4')">
	</div>
	<?php } else{?>
		 <div id="four" style="padding:10px;">
		<?php if ($SCORE < 75) {echo $special1;}
		else{
			if ($MYSCORE > 7.8) {echo $special2;}
			else {echo $special3;}
			}?>
	<?php }?>
			</div>
</section>

<!--Using a form as a pop-up window to interact with users and to give input to the cookie -->
	<div id="my_popup" style = "background-color: white; display: none; padding: 20px;">
      <form name="form1" action="#" method="post">
	     <div>Please enter your name:</div>
		 
	     <!--Text input -->
         <input name="name" id="uname" type="text" /><p>
	
	     <!--The "log in" button and recall the set cookie function "mixCookie()" when click -->
	     <input type="submit" onclick="mixCookie(); ga('send', 'event', 'registration', 'logon', document.getElementById('uname').value)" value="Log In"/> <p>
	  </form>
	</div>
	
	<div id="bookdeets" style = "background-color: white; display: none; padding: 20px;">
       <div id="showbookdeets"></div>
       <input type="hidden" id="bookshelf"  value="0">	
	
       <!--MIDTERM ADDITIONS - CHANGED TO BUTTON TO CLOSE-->
	    <!--Need further modify ga function when $LATEST is true -->
	   <button id="deetcta" class="bookdeets_close"  onClick="ga('send', 'event', 'convert', 'cart_add', document.getElementById('bookshelf').value)"/>Add to Cart</button> <p>
	</div>
 </body>
 </html>