<?php
class Comment {
	private $errorCount;
	private $errors;
	private $formInput;
	private $comment;
	private $threadRef;
	private $commentId;
	private $submitterId;
	private $submitterName;
	
	public function __construct($formInput = null) {
		$this->formInput = $formInput;
		Messages::reset();
		$this->initialize();
	}

	public function getError($errorName) {
		if (isset($this->errors[$errorName]))
			return $this->errors[$errorName];
		else
			return "";
	}

	public function setError($errorName, $errorValue) {
		// Sets a particular error value and increments error count
		if (!isset($this->errors, $errorName)) {
   		   $this->errors[$errorName] =  Messages::getError($errorValue);
		   $this->errorCount ++;
		}
	}

	public function getErrorCount() {
		return $this->errorCount;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getSubmitterName() {
		return $this->submitterName;
	}
	
	public function getThreadRef(){
		return $this->threadRef;
	}
	public function getComment(){
		return $this->comment;
	}
	public function getCommentId(){
		return $this->commentId;
	}
	
	public function getSubmitterId(){
		return $this->submitterId;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("comment" => $this->comment,
							"commentId" => $this->commentId,
							"threadRef" => $this->threadRef,
							"submitterId" => $this->submitterId
		); 
		return $paramArray;
	}

	public function __toString() {
		$str = "Submitter name: ".$this->submitterName.
		       " Thread: ".$this->threadBody.
		       " Thread Title:" .$this->threadTitle;
		return $str;
	}
	
	private function extractForm($valueName) {
		// Extract a stripped value from the form array
		$value = "";
		if (isset($this->formInput[$valueName])) {
			$value = trim($this->formInput[$valueName]);
			$value = stripslashes ($value);
			$value = htmlspecialchars ($value);
			return $value;
		}
	}
	private function initialize() {
		$this->errorCount = 0;
		$this->commentId = 0;
		$this->errors = array ();
		if (is_null ( $this->formInput )){
			$this->initializeEmpty();
		}else {
			$this->comment = $this->extractForm('commment');
			//$this->threadRef = $this->extractForm('threadRef');
			//$this->submitterId = $this->extractForm('submitterId');
		}
	}

	private function initializeEmpty() {
		
	}


	public function setSubmitterName($name) {
		$this->submitterName = $name;
	}
	
	public function setThreadRef($ref){
		$this->threadRef = $ref;
	}
	public function setComment($comment){
		$this->comment = $comment;
	}
	public function setCommentId($id){
		$this->commentId = $id;
	}
	
	public function setSubmitterId($id){
		$this->submitterId = $id;
	}
}
?>