<form name="f_user" id="f_user" action="" method="post">
<fieldset>
<label for="f_name"> Name </label>
<input type="text" name="object[user_name]" id="f_name" required/></br>

<label for="f_nickname"> nickname </label>
<input type="text" name="object[nickname]" id="f_nickname" required/></br>

<label for="f_Password"> Password </label>
<input type="password" name="object[password]" id="f_Password" required/></br>

<label for="f_RePassword"> Re-Password </label>
<input type="password" name="object[re_password]" id="f_RePassword" required/></br>

<label for="f_grade"> Grade </label>

<select id="f_grade" name="object[user_levels_id]">
	<?php while ($grade = $grades->fetch()){
		echo "<option value='{$grade['id']}'> {$grade['name']} </option>";	
	
	} ?>

</select></br>

<input type="submit"/>
<input type="hidden" name="Action" value="update"/>
<input type="hidden" name="Control" value="user"/>
<input type="hidden" name="index" value="<?php echo $id;?>"/>
</fieldset>
</form>

