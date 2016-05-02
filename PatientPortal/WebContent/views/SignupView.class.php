<?php  
class SignupView {
	public static function show($signup) {
		SignupView::showDetails($signup);
	}
	
	public static function showDetails($signup) {
?>	
	<h1>User Registration Form</h1>
	<form action="signup" method="Post">
	<p>
	<input type="text" name="firstName" tabindex="1" value="John" required>
<br><br>
	Last name: 
	<input type="text" name="lastName" tabindex="2" value="Doe" required>
<br><br>
	Gender: 
	<input type="radio" name="gender" value="male" tabindex="3" checked required>Male 
	<input type="radio" name="gender" value="female" tabindex="4"  required>Female
<br><br>
	Username:
	<input type="text" name="username" tabindex="5" value="johndoe" required>
<br><br>
	Your email:  
	<input type="email" name="email" tabindex="6" value="a@yahoo.com" required>
<br><br>
	Password:
	<input type="password" name="password" tabindex="7" value="password" required>
<br><br>
	Your Website:
	<input type="url" name ="your website" tabindex="8" value="http://www.cs.utsa.edu/~cs4413/labs/lab2Details.html" required>
<br><br>
	Your phone:
	<input type="tel" name="telephone" tabindex="9" value="555-555-5555" required>
<br><br>
	What color for errors: 
	<input type = "color" name = "errorColor" tabindex="10" value="#ff0000" required>
<br><br>
	Date:
	<input type = "month" name = "date" tabindex="11" value="2015-09" required>
<br><br>
	File upload:
	<input type = "file" name = "file" tabindex="12"><br>
</p>

	<select>
 		<option value="o1">option1</option>
  		<option value="o2">option2</option>
  		<option value="o3">option3</option>
  		<option value="o4">option4</option>
	</select>
	<br><br>
	
	<label>Select an option</label>
	<input list="datalist">
	<datalist id="datalist">
  		<option value="option1" label = "option1">
  		<option value="option2" label = "option2">
  		<option value="option3" label = "option3">
  		<option value="option4" label = "option4">
  		<option value="option5" label = "option5">
	</datalist>
	<br><br>
	
	<fieldset>
		<legend>General Expertise:</legend>
		<input type="checkbox" name="expertise" value="" tabindex="13" checked> Systems & Software<br>
		<input type="checkbox" name="expertise" value="" tabindex="14"> Hardware<br>
		<input type="checkbox" name="expertise" value="" tabindex="15" checked> Security<br>
		<input type="checkbox" name="expertise" value="" tabindex="16"> Networks<br>
	</fieldset>
	<p> <a href="profile">Submit Registration</a></p>
	</form>
</body>
</html>
<?php 
  }
}
?>