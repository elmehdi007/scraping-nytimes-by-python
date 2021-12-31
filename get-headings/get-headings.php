<?php

$doc = new DOMDocument();
$doc->loadHTML('<h1>John Doe 1</h1>
<p>Promotion: A.Sc. 2</p>
<p>Campus de Paris</p> 
<h5>John Doe 5</h5>
<p>Campus de Paris</p> 
<h3>John Doe 3</h3>
<p>Campus de Paris</p> 
<p>Campus de Paris</p> 
<p>Campus de Paris</p> 
<h4>John Doe 4</h4>
<h2>John Doe 2</h2>
<p>Campus de Paris</p> 
<p>Campus de Paris</p> 
<p>Campus de Paris</p> 
<h6>John Doe 6</h6>

');

$xpath = new DOMXpath($doc);
$htags = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');
$headings = [];

foreach($htags as $htag) 
	$headings[] = ['node'=>$htag->ownerDocument->saveHTML($htag),'nodeValue'=>$htag->nodeValue];



print_r( $headings );



?>