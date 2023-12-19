<?php
	class User {

		private $con;
		private $username;

		public function __construct($con, $username) {		//pass con and username as parameter
			$this->con = $con;
			$this->username = $username;
		}

		public function getUsername() {
			return $this->username;
		}

	}
?>