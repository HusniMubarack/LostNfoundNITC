<!DOCTYPE html>
<html>
<head>

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
</head>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db="SEPROJ";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
// if ($conn) {
//   echo "Connected-successfully";
// }
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])){
  $selected_val = $_POST['user_id'];  // Storing Selected Value In Variable
  $qry="SELECT * FROM User WHERE ID=" . $selected_val;

  $result = mysqli_query($conn,$qry);

  $row  = mysqli_fetch_array($result);
  if(is_array($row)) {
    $_SESSION['user_id'] = $row['ID'];
  }
}

if($_SESSION['user_id']=="")
{
  header('Location:http://localhost/files/LostNFound/login.php');
}

?>

<body style="padding:0;margin:0;font-family: Verdana;">


  <div class="navBar">
    <ul class="navItemList">
      <li><div class="navtitle"><a href="#"><b>Lost & Found</b></a></div></li>
      <li style="font-family: Verdana;float:right;margin-right:5px;"><a href="login.php"><b>Logout</b></a></li>


    </ul>
  </div>

<center>

    <div id="feeds">
      <h2 align="left">Add Blog</h2>
        <div align="left">
          <form id="newBlog" action="addblog.php" method="post">
          <textarea id="text" maxlength="250" name="blogdesc" rows="6" cols="100" placeholder="Add your lost and found description here" required></textarea><br />
          <input class="subButton" type="submit" name="submit-blog" value="Add Blog"/>
          </form>
        </div>


        <br>
        <h2 align="left">New Posts</h2>
<?php
$sql1= "SELECT isAdmin FROM user WHERE ID=".$_SESSION['user_id']." AND isAdmin=1";
$isAdmin = mysqli_query($conn,$sql1);
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
      $vname=','.$_SESSION['user_id'].',';
      $votes=$row['vote'];

// code for new table

      $sql2 = "SELECT ID FROM votecount WHERE userId=".$_SESSION['user_id']." AND postNo=".$ref_no;
      $result2 = mysqli_query($conn,$sql2);

// code for new table


      if($owner_id==$_SESSION['user_id'] || mysqli_num_rows($isAdmin)!=0)
      {
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

          <div class="blogdel" >
            <form method="post" action="delete_blog.php" >
            <input style="position:relative;right:-91%;"class="subButton" type="submit" name="' .$ref_no. '" value="Delete">
            </form>
          </div>
        </div>
        ';
      }
// code for new table

      elseif (mysqli_num_rows($result2)!=0) {
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
// code for new table

      // elseif (strpos($votes, $vname) !== false) {
      //   echo '
      // <div align="left" class="blog">
      //   <div class="blogOwner">
      //     <p><b>'
      //       .$owner.'
      //     </b></p>
      //   </div>
      //    <div class="blogTime">
      //     <p style="font-size:12px">'
      //       .$time.'
      //     </p>
      //   </div>
      //   <br />
      //   <div class="blogdesc">
      //     <p>'
      //       .$desc.'
      //     </p>
      //   </div>
      //
      //   </div>';
      // }
      else
      {
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
        </div><br/>

        <div class="repSpam">
          <form action="reportSpam2.php" method="post">
            spam?
            <input  type="submit" name="Yes ' .$ref_no. '"  value="Yes">
            <input  type="submit" name="No ' .$ref_no. '"  value="No">

            </form>
        </div>
      </div>
      ';
      }

    }
  }
}
// mysqli_close($conn);

?>





    </div>
</center>
</body>
</html>
