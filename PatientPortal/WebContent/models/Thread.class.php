<?php
class Thread {
	private $errorCount;
	private $errors;
	private $formInput;
	private $threadTitle;
	private $threadBody;
	private $threadId;
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
	
	public function getThreadId(){
		return $this->threadId;
	}
	public function getThreadTitle(){
		return $this->threadTitle;
	}
	public function getThread(){
		return $this->threadBody;
	}
	
	public function getSubmitterId(){
		return $this->submitterId;
	}
	
	public function getParameters() {
		// Return data fields as an associative array
		$paramArray = array("submitterName" => $this->submitterName,
				            "threadBody" => $this->threadBody,
							"threadTitle" => $this->threadTitle,
							"threadId" => $this->threadId,
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
		$this->threadId = 0;
		$this->errors = array ();
		if (is_null ( $this->formInput )){
			$this->initializeEmpty();
		}else {
			$this->validateSubmitterName();
			$this->validateThread();
			$this->validateThreadTitle();
		}
	}

	private function initializeEmpty() {
		$this->errorCount = 0;
	 	$this->submitterName = "";
	 	$this->threadBody = "default body";
	 	$this->threadTitle = "default title";
	}

	private function validateSubmitterName() {
		// First name should only contain letters
		$this->submitterName = $this->extractForm('submitterName');
		if (empty($this->submitterName))
			$this->setError('submitterName', 'SUBMITTER_NAME_EMPTY');
		elseif (!filter_var($this->submitterName, FILTER_VALIDATE_REGEXP,
			array("options"=>array("regexp" =>"/^([a-zA-Z])+$/i")) )) {
			$this->setError('submitterName', 'SUBMITTER_NAME_HAS_INVALID_CHARS');
		}
	}
	private function validateThreadTitle(){
		$this->threadTitle = $this->extractForm('threadTitle');
		/* Letting it be empty for easier testing
		if (empty($this->threadTitle))
			$this->setError('threadTitle', 'THREAD_TITLE_EMPTY');
			*/
	}
	
	private function validateThread() {
		$this->threadBody = $this->extractForm('threadBody');
		/* Letting it be empty for easier testing
		if (empty($this->thread)) 
			$this->setError('thread', 'THREAD_EMPTY');
			*/
	}

	public function setThreadId($id) {
		// Set the value of the submissionId to $id
		$this->threadId = $id;
	}
	public function setThreadBody($body){
		$this->threadBody = $body;
	}
	public function setThreadTitle($title){
		$this->threadTitle = $title;
	}
	public function setSubmitterId($id){
		$this->submitterId = $id;
	}
	public function setSubmitterName($name){
		$this->submitterName = $name;
	}
}
?>