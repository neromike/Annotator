<?php
session_start();
$error = "";
if (isset($_GET['error'])) {
	$error = $_GET['error'];
} else {
	$user_log = "";
	if (isset($_POST['username'])) {
		if ($_POST['username'] != "") {
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$fh=fopen("users.txt", "r");
			while($line = fgets($fh)) {
				$thisline = explode("\t", $line);
				$user_check = str_replace("\r", "", $thisline[0]);
				$user_check = str_replace("\n", "", $user_check);
				$pass_check = str_replace("\r", "", $thisline[1]);
				$pass_check = str_replace("\n", "", $pass_check);
				$role_check = str_replace("\r", "", $thisline[2]);
				$role_check = str_replace("\n", "", $role_check);
				if (($user_check == $user) && ($pass_check == $pass)) {
					$user_log = $user;
					break;
				}
			}
			fclose($fh);			
			if ($user_log != "") {
				$_SESSION["user"] = $user_log;
				$_SESSION["pass"] = $pass;
				$_SESSION["role"] = $role_check;
				header( 'Location: index.php' );
			} else {
				$error = "bad cred";
			}
		} else {
			$error="no user";
		}
	}
}
?>
<?php include("header.php"); ?>

<style>
input { padding: 5px; }
#login_box {
	text-align: center;
	padding-top: 100px;
}
#error_box {
	padding: 15px;
	background-color: #F7FCC1;
	color: #B13535;
	font-weight: bold;
	border-radius: 10px;
	border: solid 1px grey;
	width: 300px;
	margin: 0 auto;
	margin-top: 10px;
	margin-bottom: 10px;
}
</style>

<div id="login_box">
	<h1>Annotation Assistant Login</h1>
	<div id="error_box" <?php if ($error=="") { echo "style='display:none;' "; } ?>>
		<?php
			if ($error == "no user") {
				echo "Please provide a username.";
			} elseif ($error == "bad cred") {
				echo "Incorrect username/password combination.";
			} elseif ($error == "submit_log") {
				echo "You cannot submit annotations unless you are logged in.";
			}
		?>
	</div>
	<form action="login.php" method="post">
		<input type="text" name="username" placeholder="Username" />
		<br />
		<input type="password" name="password" placeholder="Password" />
		<br />
		<input type="submit" />
	</form>
	<br />
	<center>
		<div style="border:1px solid grey; border-radius:20px; width:300px">
			<h3><u>Test accounts</u></h3>
			<table>
				<tr>
					<th>Username</th>
					<th>Password</th>
					<th>Role</th>
				</tr>
				<tr>
					<td>annot</td>
					<td>test</td>
					<td>Annotator</td>
				</tr>
				<tr>
					<td>editor</td>
					<td>test</td>
					<td>Editor</td>
				</tr>
			</table>
		</div>
	</center>
</div>
	
<?php include("footer.php"); ?>