<?php
class ThreadDB {
	
	public static function addThread($thread) {
		// Inserts $submission into the Submissions table and returns submissionId
		$query = "INSERT INTO Threads (threadBody, submitterId, threadTitle)
		                      VALUES(:threadBody, :submitterId, :threadTitle)";
		try {
			if (is_null($thread) || $thread->getErrorCount() > 0)
				return $thread;
			$db = Database::getDB ();
			$users = UsersDB::getUsersBy('userName', $thread->getSubmitterName());
			if (empty($users)) {
				$thread->setError('submitterName', 'SUBMITTER_NAME_DOES_NOT_EXIST');
				return $thread;
			}
			$thread->setSubmitterId($users[0]->getUserId());
			if ($thread->getErrorCount() > 0)
				return $thread;
			$statement = $db->prepare ($query);
			$statement->bindValue(":threadBody", $thread->getThread());
			$statement->bindValue(":threadTitle", $thread->getThreadTitle());
			$statement->bindValue(":submitterId", $thread->getSubmitterId());
			$statement->execute ();
			$statement->closeCursor();
			$returnId = $db->lastInsertId("threadId");
			$thread->setThreadId($returnId);
		} catch (Exception $e) { // Not permanent error handling
			$thread->setError('threadId', 'SUBMISSION_IDENTITY_INVALID');
		}
		return $thread;
	}
	
	public static function getThreadRowSetsBy($type = null, $value = null) {
		// Returns the rows of Assignments whose $type field has value $value
		$allowedTypes = array("threadId", "submitterId", "threadTitle", "threadBody", "submitterName");
		$typeAlias = array("submitterName" => "Users.userName");
		$threadRowSets = array();
		try {
			$db = Database::getDB ();
			$query = "SELECT Threads.threadId, Threads.threadBody, Threads.threadTitle, 
	   		          Threads.threadTitle, Users.userName as submitterName
	   		          FROM Threads LEFT JOIN Users ON Threads.submitterId = Users.userId";

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
			$threadRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor ();
		} catch ( PDOException $e ) { // Not permanent error handling
			
		}
		return $threadRowSets;
	}
	
	public static function getThreadsArray($rowSets) {
		// Return an array of Assignment objects extracted from $rowSets
		$threads = array();

		foreach ($rowSets as $threadRow ) {
			$thread = new Thread($threadRow);
			$thread->setThreadId($threadRow['threadId']);
			$thread->setThreadBody($threadRow['threadBody']);
			$thread->setThreadTitle($threadRow['threadTitle']);
			array_push ($threads, $thread);
		}
		return $threads;
	}
	
	public static function getThreadsBy($type=null, $value=null) {
		// Returns Assignment objects whose $type field has value $value
		$threadRows = ThreadDB::getThreadRowSetsBy($type, $value);
		return ThreadDB::getThreadsArray($threadRows);
	}
	public static function getThreadValues($rowSets, $column) {
		// Returns an array of values from $column extracted from $rowSets
		$threadValues = array();
		foreach ($rowSets as $threadRow )  {
			$threadValue = $threadRow[$column];
			array_push ($threadValues, $threadValue);
		}
		return $threadValues;
	}
	
	public static function getThreadValuesBy($column, $type=null, $value=null) {
		// Returns the column of the Assignments whose $type field has value $value
		$threadRows = ThreadDB::getThreadRowSetsBy($type, $value);
		return ThreadDB::getThreadValues($threadRows, $column);
	}
	
	public static function updateAssignment($assignment) {
		// Update a submission
		try {
			$db = Database::getDB ();
			if (is_null($assignment) || $assignment->getErrorCount() > 0)
				return $assignment;
			$checkAssignment = AssignmentsDB::getAssignmentsBy('assignmentId', $assignment->getAssignmentId());
			if (empty($checkAssignment))
				$assignment->setError('assignmentId', 'ASSIGNMENT_DOES_NOT_EXIST');
			elseif ($checkAssignment[0]->getAssignmentOwnerName() != $assignment->getAssignmentOwnerName())
			    $assignment->setError('assignmentOwnerName', 'ASSIGNMENT_OWNER_NAME_DOES_NOT_MATCH');
			if ($assignment->getErrorCount() > 0)
				return $assignment;
	
			$query = "UPDATE Assignments SET assignmentDescription = :assignmentDescription,
					    assignmentTitle = :assignmentTitle
	    			    WHERE assignmentId = :assignmentId";
	
			$statement = $db->prepare ($query);
			$statement->bindValue(":assignmentDescription", $assignment->getAssignmentDescription());
			$statement->bindValue(":assignmentTitle", $assignment->getAssignmentTitle());
			$statement->bindValue(":assignmentId", $assignment->getAssignmentId());
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) { // Not permanent error handling
			$assignment->setError('assignmentId', 'ASSIGNMENT_COULD_NOT_BE_UPDATED');
		}
		return $assignment;
	}
	
}
?>