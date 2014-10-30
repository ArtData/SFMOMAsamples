 <?php 
 	function CallAPI($method, $url, $data = false, $getHeader = false)
	{
	    $curl = curl_init();

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    // Optional Authentication:
	    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($curl, CURLOPT_USERPWD, "USERNAME:PASSWORD");

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    if($getHeader) { curl_setopt($curl, CURLOPT_HEADER, 1); }

		$response = curl_exec($curl);
		
		if($getHeader){
			$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$result = substr($response, $header_size);			
		}else{
			$result = $response;
			$header = null;
		}

	    curl_close($curl);

	    return array('header' => $header, 'body' => $result);
	}
 ?>

 <?php echo 'How long is the SFMOMA Collection?'; ?> 
 <?php 
 	//$result = CallAPI('GET', 'https://api.sfmoma.org/collection/artworks', false, true);
 	// this is hardcoded until we add envolopes to the response
 	$totalPages = 54; 
	$totalLength = 0.0;
	$totalNumOfWorks = 0;
	$totalNumOfWorksWithDimensions = 0;
	// next step is to also find the biggest single thing
	$biggestThing = array('width' => 0.0, 'height' => 0.0, 'depth' => 0.0);
	$biggestPicture = array('width' => 0.0, 'height' => 0.0);

	// get every artwork, 1000 at a time
	for ($i=1; $i < $totalPages; $i++) { 
	 	$result = CallAPI('GET', 'https://api.sfmoma.org/collection/artworks?per_page=1000&page=' . $i . '&fields=dimensions,departments');
	 	$temp = json_decode($result['body'], true);
	 	for ($j=0; $j < count($temp); $j++) { 
		 	$dimensions = $temp[$j]['dimensions'];
		 	$display = $dimensions['display'];
		 	$displayParts = preg_split("/[\s())]+/", $display);
		 	$width = 0.0;
		 	$height = 0.0;
		 	$depth = 0.0;
		 	$growth = 0.0;
		 	if(count($displayParts)>5){
		 		for ($k=0; $k < count($displayParts); $k++) { 
		 			if( ($displayParts[$k]=='in.') && ($displayParts[$k+1])){
		 				$growth = floatval($displayParts[$k+1]);
		 			}
		 			if( ($displayParts[$k]=='x') && ($displayParts[$k+1]) && ($growth > 0) ){
			 			$nextDimension = floatval($displayParts[$k+1]);			 			
				 		$growth = ($growth > $nextDimension) ? $growth : $nextDimension ;
		 			}
		 		}
		 	}
		 	$totalNumOfWorks++;
		 	if($growth > 0){
		 		$totalNumOfWorksWithDimensions++;
		 		$totalLength += $growth;
		 	}
		 	
	 	}
		echo "\n";
 		echo 'The running total for page ' . $i . ' of 53 is: ' . $totalLength . ' cm';
 		usleep(100000);
	} 
	echo "\n\n";
	$miles = $totalLength/160934;
 	echo 'The grand total is: ' . $totalLength . ' cm!'. "\n" . " Which is " . $miles . " miles for the Americans in the audience.";
	echo "\n\n";
 	echo "We don't know the size of everying. We have dimensions for " . $totalNumOfWorksWithDimensions + ' out of ' + $totalNumOfWorks + " artworks" + "\n\n";
 ?>
 </body>
</html>