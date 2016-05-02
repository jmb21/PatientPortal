<?php  
function registerForm($user) {
	$user = (array_key_exists ( 'user', $_SESSION )) ? $_SESSION ['user'] : null;
	$base = (array_key_exists ( 'base', $_SESSION )) ? $_SESSION ['base'] : "";
	echo '<div class="container-fluid">';
	echo '<div class="row">';
	echo '<div class="col-md-3 col-sm-2 hidden-xs"></div>';
	echo '<div class="col-md-6 col-sm-8 col-xs-12">';
	echo '<h1>'.$_SESSION['headertitle'].'</h1>';
	echo '<form role="form" action ="/' . $base . '/user/new" method="Post">';
   
	if (!is_null($user) && !empty($user->getError('userId'))) {
   		echo  '<div class="form-group">';
   		echo  '<label><span class="label label-danger">';
   		echo  $user->getError('userId');
   		echo '</span></label></div>';
   	}
   	echo '<div class="form-group">'; // User name
   	echo '<label for="userName">User name:';
   	echo '<span class="label label-danger">';
   	if (!is_null($user))
   		echo $user->getError('userName');
   	echo '</span></label>';
   	echo '<input type="text" class="form-control" id = "userName" name="userName"';
   	if (!is_null($user))
   		echo 'value = "'. $user->getUserName() .'"';
   	echo 'required>';
   	echo '</div>';
   
   	echo '<div class="form-group">'; // Password
   	echo '<label for="password">Password:';
   	echo '<span class="label label-danger">';
   	if (!is_null($user))
   		echo $user->getError('password');
   	echo '</span></label>';
   	echo '<input type="password" class="form-control" id = "password" name="password"';
   	echo 'required>';
   	echo '</div>';
   
   	echo '<div class="form-group">'; // Retype
   	echo '<label for="passwordRetry">Retype password:';
   	echo '<span class="label label-danger">';
   	if (!is_null($user))
   			echo $user->getError('password');
   	echo '</span></label>';
   	echo '<input type="password" class="form-control" id = "passwordRetry" name="passwordRetry" onblur="checkPasswordMatch()"';
   	echo 'required>';
   	echo '</div>';
   	echo '<span id="retypedError" class="error"></span></p>';
   
   	echo '<button type="submit" class="btn btn-default">Submit</button>';
   	echo '</form>';
   	echo '</div>';
   	echo '<div class="col-md-3 col-sm-2 hidden-xs"></div>';
   	echo '</div>';
   echo '</div>';
}
?>