<?php
	include_once('Song.php');

	init();
	function init(){
		
		searchSongs();
	}

	function searchSongs() {
		$artist_name = $_POST['artistname'];
		$artist_name = str_replace(" ", "+", $artist_name);

		$mSearchTerm = "https://api.musixmatch.com/ws/1.1/track.search?apikey=7dac0375a1ac819afa93306c3dde9068&q_artist=";
		$mSearchTerm .= $artist_name;
		$mSearchTerm .= "&page_size=10&s_track_rating=desc";

		$result = execSearchTerm($mSearchTerm);

		$namearray = json_decode($result, true);

		$track_list = $namearray["message"]["body"]["track_list"];
		$songarray = array();

		for ($x = 0; $x < sizeof($track_list) ; $x++) {
			$track_name = $track_list[$x]["track"]["track_name"];
			$track_id = $track_list[$x]["track"]["track_id"];
			//echo $track_name."<br>";
			$track_lyrics = searchLyrics($track_id);
			$track_lyrics = parseLyrics($track_lyrics);
			//$song = new Song($track_name, $track_lyrics, $artist_name);
			$songarray[] = $track_name;
			$songarray[] = $track_lyrics;
		}
		echo json_encode($songarray);

	}

	function searchLyrics($track_id) {
		$mSearchTerm = "https://api.musixmatch.com/ws/1.1/track.lyrics.get?apikey=7dac0375a1ac819afa93306c3dde9068&track_id=";
		$mSearchTerm .= $track_id;

		$result = execSearchTerm($mSearchTerm);

		$lyrics = json_decode($result, true);
		$lyrics_body = $lyrics["message"]["body"]["lyrics"]["lyrics_body"];
		return $lyrics_body;
	}

	function parseLyrics($lyrics_body) {
		$useless_words = array('the','#', '*', '.', ',', '&', '@', '!', '/', '?', '"', '(', ')');
		for ($x = 0; $x < sizeof($useless_words) ; $x++) {
			$lyrics_body = str_replace($useless_words[$x], "", $lyrics_body);
		}
		$lyrics_body = str_replace("This Lyrics is NOT for Commercial use", "", $lyrics_body);
		return $lyrics_body;
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