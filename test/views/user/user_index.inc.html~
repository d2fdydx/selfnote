<?php
if (isset($_GET['notice'])){ 
	$temp = htmlEntities($_GET['notice']);
	echo <<< ETD
	<div id="notice">
	{$temp}
	</div>
ETD;
}
?>
<h3> users </h3>
<table>
<tr>
	<td> id </td>
	<td> User Name </td>
	<td> Nickname </td>
	<td> Grade </td>
	<td> Edit </td>
	<td> Delete </td>
</tr>
<?php 


while ($user = $users->fetch()) {

 echo '<tr>';
 echo '  <td>'. $user["id"].' </td> <td>'.$user["user_name"].'</td>  <td>'.$user["nickname"].'</td> ';
 echo "<td>{$user['user_levels.name']} </td>";
 echo '<td> <a href="/user/edit/'.$user['id'].'"> Edit </a> </td>';
 echo '<td><a href="" class="Critical" value='.$user['id'].'> delete</a></td>';
 echo '</tr>';
 } 
 
 ?>
 
 <div id="dialog-confirm" title="Delete?" style="display: none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span> Are you sure?</p>
</div>
 </table>