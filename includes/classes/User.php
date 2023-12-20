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

		public function getEmail() {
			$query = mysqli_query($this->con, "SELECT email FROM user WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getFirstAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM user WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}
	}
?>