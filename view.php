<?php
function get_data()
{
$link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
	mysqli_select_db($link,'dblogin');// or die('Cannot select the DB');

	/* grab the posts from the db */
    $query = "SELECT * FROM `tbluser`";
    //  ORDER BY ID DESC LIMIT $number_of_posts";
	$result = mysqli_query($link,$query) or die('Errant query:  '.$query);
$tbluse_data=array();
while ($row =mysqli_fetch_array($result))
{
	$tbluse_data[]=array(
		'userid' => $row['Userid'],
		'password1' => $row['password1']
		);

}


return json_encode($tbluse_data);
}

$file_name=date('d-m-Y').'.json';
if (file_put_contents($file_name,get_data()))
{

	echo $file_name.'file created';
}
else{
	echo 'error';
}

?>
