
<?php

/* require the user as the parameter */
if((isset($_GET['u']))&&(isset($_GET['p'])))
  {
   
	/* soak in the passed variable or set our own */
//	$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
    //$format='json';
	$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default
    $user_id = $_GET['u']; //no default
    $pass_id = $_GET['p']; //no default

	/* connect to the db */
	$link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
	mysqli_select_db($link,'dblogin');// or die('Cannot select the DB');

	/* grab the posts from the db */
    $query = "SELECT count(*) as c FROM `tbluser` WHERE `Userid` ='". $user_id ."'
    AND password1 ='".$pass_id."'";
    //  ORDER BY ID DESC LIMIT $number_of_posts";
	$result = mysqli_query($link,$query) or die('Errant query:  '.$query);

	/* create one master array of the records */
	$posts = array();
	if(mysqli_num_rows($result)) {
		while($post = mysqli_fetch_assoc($result)) {
			$posts[] = array('post'=>$post);
		}
	}

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('posts'=>$posts));
	}
	else if($format == 'xml')  {
		header('Content-type: text/xml');
		echo '<posts>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</posts>';
	}

	/* disconnect from the db */
	@mysql_close($link);
}

?>
