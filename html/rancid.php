<!DOCTYPE html>
<html>
	<!-- CSCB20 Assignment 2: Rancid Tomatoes Web page -->
	
	<?php
	$film = $_REQUEST['film'];

	header('Content-Type: text/plain');
	$file = "./" . $film . "/info.txt";
	$all_data = file_get_contents($file); 				//creates a string of contents in file
	$lines = explode("\n", $all_data); 					//separates the lines of file and creates an array
	$file = "./" . $film;					
	$reviews = glob($file . "/review*.txt");			//$reviews is an array of all the review files for the given $film
	$reviews_left_left = array();						//$review_left_left will hold reviews to be inserted in the left column of reviews
	$reviews_left_right = array();						//$review_left_right will hold reviews to be inserted in the right column of reviews

	$total = count($reviews);							//$ is the total number of reviews
	
	$count = 0;

	//distribute the reviews evenly in left and right columns
	
	foreach ($reviews as $review)
	{
		if ($count <= ceil(($total/2)-1))
		{
			array_push($reviews_left_left, $review);
		}
		else
		{
			array_push($reviews_left_right, $review);
		}
		$count++;
	}	

	// arrange_reviews arranges the reviews given in the files in $array and displays it in proper format
	function arrange_reviews($array)
	{
		foreach ($array as $review) 
		{
			header('Content-Type: text/plain');
			$data = file_get_contents($review);
			$lines = explode("\n", $data);
			review_format($lines);
		}
	}

	// arrange review_format arranges the contents of a given string representing review in proper format
	function review_format($lines)
	{
		?>
		<p class='comment'>
		<?
		if ($lines[1] == 'ROTTEN')
		{
			?> 
			<img class='rotten_fresh' src='https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/rotten.gif' alt='Rotten'/>
			<?
		}
		else
		{
			?> 
			<img class='rotten_fresh' src='https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/fresh.gif' alt='Fresh'/>
			<?
		}
		?>
			<q> <?= $lines[0]?> </q>
		</p>
		<p class='reviewer'>
		<img class='critic' src='https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/critic.gif' alt='Critic'/>
		<?= $lines[2]?>  <br/>
		<i> <?= $lines[3]?> </i>
		</p>
		<?
	}

	?>

	<head>
		<link rel="icon" href="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/rotten.gif" type="image/x-icon"/>
		<title> <?= $lines[0];?>- Rancid Tomatoes
		</title>

		<meta charset="utf-8" />
		<!-- Link to CSS file that you should create -->
		<link href="rancid.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
		<div id="banner">
			<img src="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/banner.png" alt="Rancid Tomatoes"/>
		</div>

		<h1> <?= $lines[0];?> (<?= $lines[1]?>)</h1>
		<div id="review">
		
		<div id="check">
		<div id="review_left">
		<div id="overall_rating">
			<?php
			if ($lines[2] >= 60)
			{
				?>
				<img id='overall_ratingbg' src='https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/freshbig.png' alt='Rotten' />
				<?php
			}

			else
			{
				?>
				<img id='overall_ratingbg' src='https://mathlab.utsc.utoronto.ca/courses/cscb20w13/nunesrol/img/rottenbig.png' alt='Rotten' />
				<?
			}
			?>
			<?= $lines[2]?>%
			
		</div>

	

	<div id="review_left_left">
		<?php 
		arrange_reviews($reviews_left_left);
		?>
	</div>
	
	<div id="review_left_right">
		<?php
		arrange_reviews($reviews_left_right);
		?>
	</div>


	</div>
	
	<div id="review_right">
		<div id="overviewimg">
			<img src="./<?= $film?>/overview.png" alt="general overview"/>
		</div>
		
		<div id="general_overview">
		<dl>
			<?php
			header('Content-Type: text/plain');
			$overview = file_get_contents("./" . $film . "/overview.txt");
			$defns = explode("\n", $overview);

			foreach ($defns as $def)
			{
				$parts = explode(":", $def);
				?>
				<dt class='defn'> <?= $parts[0];?> </dt>
				<dd> <?= $parts[1];?> </dd>
				<?
			}
			?>

		</dl>
	</div>
	</div>
	</div>
	<table id="pages">
	<tr><td> (1-<?= $total;?>) of <?= $total;?> </td></tr>
	</table>
	</div>
	

		<div id="validators">
			<a class="validators_img" href="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/rosselet/asn/html_validator.php"><img src="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/rosselet/asn/a2/img/w3c-html.png" alt="Valid HTML5" /></a> <br />
			<a class="validators_img" href="../../css_validator.php"><img src="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/rosselet/asn/a2/img/w3c-css.png" alt="Valid CSS" /></a> <br/>
		</div>
	</body>
</html>