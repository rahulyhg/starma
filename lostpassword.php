<?php
 
require_once "header.php"; 
?>

 
<?php
if (isset($_POST['lostpass'])){
 
	if (lostPassword($_POST['nickname'],$_POST['email'])){
 
		echo "Your password has been reset, an email containing your new password has been sent to your inbox.<br />
		<a href='./index.php'>Click here to return to the homepage.</a>
		";
 
	}else {
 
		echo "Username or email was incorrect !";
		show_lostpassword_form();
 
	}
 
} else {
	//user has not pressed the button
	show_lostpassword_form();	
}
?>

<?php 

 require_once "footer.php";
?> 