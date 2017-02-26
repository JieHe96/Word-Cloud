<?php

	init();

	function init() {
		searchArtists();
	}

	function searchArtists() {

		$artistName = str_replace(" ", "+", $_POST['inputname']);

		$spSearchTerm = "https://api.musixmatch.com/ws/1.1/artist.search?apikey=7dac0375a1ac819afa93306c3dde9068&q_artist=";
		$spSearchTerm .= $artistName."&page_size=20&s_artist_rating=desc";

		$result = execSearchTerm($spSearchTerm);

		$namearray = json_decode($result, true);
		$artlist_list = $namearray["message"]["body"]["artist_list"];
		for ($x = 0; $x < sizeof($artlist_list) ; $x++) {
			$artist_name = $artlist_list[$x]["artist"]["artist_name"];
			$artist_id = $artlist_list[$x]["artist"]["artist_id"];
			$returnresult = "<div id='artist_entry' onclick=\"searchSongs(this.innerHTML);\">";
			//$returnresult = "<div id='artist_entry'>";
		//	$returnresult .= "<div id='linkdiv'>";
			$song_communicator_link = '"php/song_communicator.php?artistname='.$artist_name."&artistid=".$artist_id.'"';
			//$returnresult .= $song_communicator_link."</div>";
			$returnresult.= $artist_name."</div>";

			//echo $song_communicator_link;
			////$artist_name ='<li onclick= searchSongs('.$song_communicator_link.')'.$artist_name.'</li>';
			//$return_list ='<li onclick="searchSongs('.$song_communicator_link.');">'.$artist_name.'</li>';
			//$returnresult .= "</div><li >".$artist_name."</li></div>";
			//$returnresult .= "<li>".$artist_name."</li>";

			echo $returnresult;
		}
	}

	function execSearchTerm($searchTerm) {
		//initialize cURL resource
		$ch = curl_init();

		//set URL options
		$options = array(CURLOPT_URL => $searchTerm,
        		         CURLOPT_RETURNTRANSFER => 1
                		);
		curl_setopt_array($ch, $options);

		//send URL to browser
		$searchresult = curl_exec($ch);

		//close URL
		curl_close($ch);
		return $searchresult;
	}
?>