<?php
	class Song {

		public $name;
		public $lyrics;
		public $artist;

		public function __construct($songname, $songlyrics, $songartist) {
			$this->name = $songname;
			$this->lyrics = $songlyrics;
			$this->artist = $songartist;
		}

	}	
?>