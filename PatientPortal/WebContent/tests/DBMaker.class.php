<?php

class DBMaker {
	public static function create($dbName) {
		// Creates a database named $dbName for testing and returns connection
		$db = null;
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . "". ";charset=utf8";
			$username = 'root';
			$password = '';
			$options = array (
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
			);
			$db = new PDO ( $dbspec, $username, $password, $options );
			$st = $db->prepare ( "DROP DATABASE if EXISTS $dbName" );
			$st->execute ();
			$st = $db->prepare ( "CREATE DATABASE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "USE $dbName" );
			$st->execute ();
			$st = $db->prepare ( "DROP TABLE if EXISTS Users" );
			$st->execute ();
			$st = $db->prepare ( "CREATE TABLE Users (
					userId             int(11) NOT NULL AUTO_INCREMENT,
					userName           varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
					password           varchar(255) COLLATE utf8_unicode_ci,
				    dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (userId)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" );
			$st->execute ();
			
			$st = $db->prepare ("CREATE TABLE Threads (
			  	             threadId       int(11) NOT NULL AUTO_INCREMENT,
				             submitterId        int(11) NOT NULL COLLATE utf8_unicode_ci,
				             dateCreated    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				             PRIMARY KEY (threadId),
				             FOREIGN KEY (submitterId) REFERENCES Users(userId)
		              )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;" );
			$st->execute ();
			
			$st = $db->prepare ("DROP TABLE if EXISTS Reviews");
			$st->execute ();
			
			$sql = "INSERT INTO Users (userId, userName, password) VALUES
		                          (:userId, :userName, :password)";
			$st = $db->prepare ( $sql );
			$st->execute (array (':userId' => 1, ':userName' => 'Jon', ':password' => 'abc'));
			$st->execute (array (':userId' => 2, ':userName' => 'Steven', ':password' => '123'));
			$st->execute (array (':userId' => 3, ':userName' => 'Kai', ':password' => 'DoReMe'));
			$st->execute (array (':userId' => 4, ':userName' => 'Mike', ':password' => 'xyz'));
			
			$sql = "INSERT INTO Threads (threadId, submitterId) 
	                             VALUES (:threadId, :submitterId)";
			$st = $db->prepare ($sql);
			$st->execute (array (':threadId' => 1, ':submitterId' => 1));
			$st->execute (array (':threadId' => 2, ':submitterId' => 1));
			$st->execute (array (':threadId' => 3, ':submitterId' => 2));
				
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
		
		return $db;
	}
	public static function delete($dbName) {
		// Delete a database named $dbName
		try {
			$dbspec = 'mysql:host=localhost;dbname=' . $dbName . ";charset=utf8";
			$username = 'root';
			$password = '';
			$options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$db = new PDO ($dbspec, $username, $password, $options);
			$st = $db->prepare ("DROP DATABASE if EXISTS $dbName");
			$st->execute ();
		} catch ( PDOException $e ) {
			echo $e->getMessage (); // not final error handling
		}
	}
}
?>