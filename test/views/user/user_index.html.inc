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
	<td> name </td>
</tr>
<?php 


$users->setFetchMode(PDO::FETCH_ASSOC);

while ($user = $users->fetch()) {

 echo ' <tr> <td>'. $user["id"].' </td> <td>'.$user["name"].'</td> </tr>';
 
 } 
 
 ?>
 </table>