<html>
<?php
session_start();
if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= "")
{
	$_SESSION["user_id"]= "";
	session_destroy();
}
?>

<style>


.navBar {
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #39B7CD;
    display: block;
    align-content: flex-start;
}
.navItemList{
  list-style-type: none;
}

.navItemList li {
    float: left;
}

.navItemList li a {
    display: block;
    color: white;
    text-align: center;
    padding: 0 16px;
    text-decoration: none;
}

/* Change the link color to #111 (black) on hover */
.navItemList li a:hover {

}
.navtitle{
  font-family: Verdana;
  color: white;
  text-align: center;
  padding: 0px 200px 14px 6px;
  margin-right: 200px;
  font-size: 20px;
  text-decoration: none;
}
.navtitle a:hover{

}

#feeds{
  align-content:center;

}
#feeds{
  border-style: solid;
  border-width: 0px;
  padding:10px;
  border-color: #333;
  border-radius: 15px;
  margin: 25px 50px;
}
.subButton{
  position: relative;
  margin-top:10px;
 background-color: #39B7CD;;
  border: none;
  color: #fff;
  border-radius: 15px;
  width: 100px;
  height: 40px;
  cursor: pointer;
}

.blogdel{
  margin-bottom:7px;
}

.blog{
  border-style: solid;
  border-width:1px;
  border-color: #DCDCDC;
  border-radius: 15px;
  margin-top:10px;
  padding:5px;
}

</style>
<body style="padding:0;margin:0;font-family: Verdana;">
	<div class="navBar">
    <ul class="navItemList">
      <li><div class="navtitle"><a href="#"><b>Lost & Found</b></a></div></li>
      <li style="font-family: Verdana;float:right;margin-right:5px;">
				<form action="index.php" method="post">
		 	  	<select name="user_id">
		 			<option value="1">Saahil</option>
		 			<option value="3">Husni</option>
		 			<option value="4">Vinod P</option>
		 			<option value="5">Admin</option>
		 		</select>
		 	   	<input type="submit" name="submit" value="Submit">
		 	 </form>
			</li>


    </ul>
  </div>

	<div id="feeds">

		<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$db="SEPROJ";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $db);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}


		$sql = "SELECT text,timestamp,name,owner,vote,refno FROM Blog,User WHERE Blog.owner=User.id ORDER BY refno DESC";
		$result = mysqli_query($conn,$sql);
		$flag = 0;

		if($result) {

		  if(mysqli_num_rows($result)>0) {
		    while($row = mysqli_fetch_assoc($result)) {
		      $flag++;
		      $desc = $row['text'];
		      $owner = $row['name'];
		      $owner_id=$row['owner'];
		      $time = $row['timestamp'];
		      $ref_no=$row['refno'];


					echo '
	      <div align="left" class="blog">
	        <div class="blogOwner">
	          <p><b>'
	            .$owner.'
	          </b></p>
	        </div>
	         <div class="blogTime">
	          <p style="font-size:12px">'
	            .$time.'
	          </p>
	        </div>
	        <br />
	        <div class="blogdesc">
	          <p>'
	            .$desc.'
	          </p>
	        </div>

	        </div>';
				}
			}
		}


?>

	</div>
</body>
</html>
