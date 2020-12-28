<?php
require_once "db.php";
if (isset($_POST['signup'])) {
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
$bdate = mysqli_real_escape_string($conn, $_POST['bdate']);
$hiredate = mysqli_real_escape_string($conn, $_POST['hiredate']);
$role = mysqli_real_escape_string($conn, $_POST['role']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']); 
if (!preg_match("/^[a-zA-Z ]+$/",$fname)) {
$fname_error = "Name must contain only alphabets and space";
}
if (!preg_match("/^[a-zA-Z ]+$/",$lname)) {
    $lname_error = "Name must contain only alphabets and space";
    }
if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
$email_error = "Please Enter Valid Email ID";
}
if(strlen($password) < 6) {
$password_error = "Password must be minimum of 6 characters";
}  

if (!preg_match('/^[0-9]{10}+$/', $mobile)){
    $mobile_error = "Mobile number must be minimum of 10 characters"; 
}

if(strlen($mobile) < 10) {
$mobile_error = "Mobile number must be minimum of 10 characters";
}

if($password != $cpassword) {
$cpassword_error = "Password and Confirm Password doesn't match";
}
if (!$error) {
if(mysqli_query($conn, "INSERT INTO users(fname, lname, email, mobile, bdate, hiredate, role, password) VALUES('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $mobile . "', '" . $bdate . "','" . $hiredate . "','" . $role . "','" . md5($password) . "')")) {
  $_SESSION['success_message'] = "Registration done successfully.";
  header("location: registration.php");
exit();
} else {
 
echo "Error: " . $sql . "" . mysqli_error($conn);
}
}
mysqli_close($conn);
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Employee registration</title>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
</head>
<body>
<!-- ---------Navbar---------- -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">AIT Staff Attendance System</a>
    </div>
    <ul class="nav navbar-nav">
    <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Attendance</a></li>
	  <li><a href="#">Feeds</a></li>
	  <li><a href="display.php">Staffs</a></li>
      <li><a href="#">Quick Links</a></li>
    </ul>
    <div class="right" style="float:right;">
    <button class="btn btn-primary navbar-btn">Logout</button>
    </div>
  </div>
</nav>

<?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                        unset($_SESSION['success_message']);
                    }
                    ?>
<!-- --------Registration Form------------ -->
<div class="container">
<div class="form-row">
<div class="col-lg-6 col-offset-2">
<div class="page-header">
<h3 style="color:Tomato;">Register New Employee Here.....</h3>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
<div class="form-group">
<label>First Name</label>
<input type="text" name="fname" class="form-control" value="" maxlength="50" required="">
<span class="text-danger"><?php if (isset($fname_error)) echo $fname_error; ?></span>
</div>
<div class="form-group">
<label>Last Name</label>
<input type="text" name="lname" class="form-control" value="" maxlength="50" required="">
<span class="text-danger"><?php if (isset($lname_error)) echo $lname_error; ?></span>
</div>
<div class="form-group ">
<label>Email</label>
<input type="email" name="email" class="form-control" value="" maxlength="30" required="">
<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="number" name="mobile" class="form-control" value="" minlength="10" maxlength="12" required="">
<span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
</div>
<div class="form-group">
<label>BirthDate</label>
<input type="date" name="bdate" class="form-control" value="" maxlength="12" required="">
<span class="text-danger"><?php if (isset($bdate_error)) echo $bdate_error; ?></span>
</div></div></div><br><br><br><br><br>
<div class="form-row">
<div class="col-lg-6 col-offset-2">

<div class="form-group">
<label>Joining Date</label>
<input type="date" name="hiredate" class="form-control" value="" maxlength="12" required="">
<span class="text-danger"><?php if (isset($hiredate_error)) echo $hiredate_error; ?></span>
</div><br>

<!--<div class="form-group">
<label>Role / Type of User:: </label><br>
<input type="radio" name="role"
<?php if (isset($role) && $role=="admin") echo "checked";?>
value="admin">Admin 
<input type="radio" name="role"
<?php if (isset($role) && $role=="staff") echo "checked";?>
value="staff">Staff
</div> -->

<div class="form-group">
<label for="role">Type of User:</label>
  <select name="role">
    <option value="Admin" <?php if (isset($role) && $role=="admin") echo "checked";?>>Admin</option>
    <option value="Intern">Staff</option>
    <option value="Pantry">Pantry</option>
    <option value="Washroom">Washroom</option>
  </select>
</div><br>


<div class="form-group">
<label>Password</label>
<input type="password" name="password" class="form-control" value="" maxlength="10" required="">
<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
</div>  
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" value="" maxlength="10" required="">
<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
</div>
<input type="submit" class="btn btn-primary btn-lg btn-block" name="signup" value="SUBMIT">

</form>
</div>
</div>    
</div>
</body>
</html>