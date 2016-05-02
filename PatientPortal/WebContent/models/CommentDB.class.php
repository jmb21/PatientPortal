<?php
class CommentDB {
	
	public static function addComment($comment) {
		// Inserts $submission into the Submissions table and returns submissionId
		$query = "INSERT INTO Comments (comment, submitterId, threadRef)
		                      VALUES(:threadBody, :submitterId, :threadTitle)";
		try {
			if (is_null($comment) || $comment->getErrorCount() > 0)
				return $comment;
			$db = Database::getDB ();
			/*$users = UsersDB::getUsersBy('userId', $comment->getSubmitterId());
			if (empty($users)) {
				$comment->setError('submitterName', 'SUBMITTER_NAME_DOES_NOT_EXIST');
				echo 'submitter error';
			}
			$comment->setSubmitterId($users[0]->getUserId());
			*/
			if ($comment->getErrorCount() > 0)
				echo 'error';
			$statement = $db->prepare ($query);
			$statement->bindValue(":comment", $comment->getComment());
			$statement->bindValue(":threadRef", $comment->getThreadRef());
			$statement->bindValue(":submitterId", $comment->getSubmitterId());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("commentId");
			$comment->setCommentId($returnId);
		} catch (Exception $e) { // Not permanent error handling
			$comment->setError('commentId', 'SUBMISSION_IDENTITY_INVALID');
			echo 'exception error';
		}
		return $comment;
	}
	
	public static function getCommentRowSetsBy($type = null, $value = null) {
		// Returns the rows of Assignments whose $type field has value $value
		$allowedTypes = array("commentId", "submitterId", "threadRef");
		$commentRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT Comments.commentId, Comments.comment, Comments.submitterId, Comments.threadRef
	   		          FROM Comments LEFT JOIN Threads ON Threads.threadId = Comments.threadRef";

			if (!is_null($type)) {
				if (!in_array($type, $allowedTypes))
					throw new PDOException("$type not an allowed search criterion for Threads");
				$typeValue = (isset($typeAlias[$type]))?$typeAlias[$type]:$type; 
			    $query = $query. " WHERE ($typeValue = :$type)";
			    $statement = $db->prepare($query);
			    $statement->bindParam(":$type", $value);
			} else 
				$statement = $db->prepare($query);
			$statement->execute ();
			$commentRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch ( PDOException $e ) { // Not permanent error handling
			
		}
		return $commentRowSets;
	}
	
	public static function getCommentsArray($rowSets) {
		// Return an array of Assignment objects extracted from $rowSets
		$comments = array();

		foreach ($rowSets as $commentRow ) {
			$comment = new Comment($commentRow);
			$comment->setCommentId($commentRow['commentId']);
			$comment->setComment($commentRow['comment']);
			$comment->setThreadRef($commentRow['threadRef']);
			$comment->setSubmitterId($commentRow['submitterId']);
			array_push ($comments, $comment);
		}
		return $comments;
	}
	
	public static function getCommentsBy($type=null, $value=null) {
		// Returns Assignment objects whose $type field has value $value
		$commentRows = CommentDB::getCommentRowSetsBy($type, $value);
		return CommentDB::getCommentsArray($commentRows);
	}
	public static function getCommentValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$commentValues = array();
		foreach ($rowSets as $commentRow )  {
			$commentValue = $commentRow[$column];
			array_push ($commentValues, $commentValue);
		}
		return $commentValues;
	}
	
	public static function getCommentsValuesBy($column, $type=null, $value=null) {
		// Returns the column of the Assignments whose $type field has value $value
		$commentRows = CommentDB::getCommentRowSetsBy($type, $value);
		return CommentDB::getCommentValues($commentRows, $column);
	}
	
	public static function updateComment($comment) {
	}
	
}
?>