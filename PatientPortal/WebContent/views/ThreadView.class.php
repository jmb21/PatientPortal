<?php
class ThreadView {

	public static function show() {
		// Show a single Submission object
		$_SESSION['headertitle'] = "Thread List";
		$_SESSION['styles'] = array('jumbotron.css');
		MasterView::showHeader();
		MasterView::showNavbar();
        self::showDetails();
        MasterView::showFooter();
	}
	
	public static function showAll() {
		// Show all submission objects on own page
		$_SESSION['headertitle'] = "List of threads";
		$_SESSION['styles'] = array('jumbotron.css');
		MasterView::showHeader();
		MasterView::showNavbar();
		self::showAllDetails();
		MasterView::showFooter();
	}
	
	public static function showAllDetails() {
		// SHow a table of submission objects with links
		$threads = (array_key_exists('threads', $_SESSION))?$_SESSION['threads']:array();
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";

	    echo '<div class="container">';
		echo '<h1>Thread List</h1>';
		echo '<div class="table-responsive">';
		echo '<table class="table table-striped">';
		echo "<thead>";
		echo "<tr><th>Submitter</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach($threads as $thread) {
			echo '<tr><td>'.$thread->getThreadId().'</td>';
			echo '<td>'.$thread->getSubmitterName().'</td>';
			echo '<td>'.$thread->getThreadTitle().'</td>';
			echo '<td><a href="/'.$base.'/thread/show/'.$thread->getThreadId().'">Show</a></td>';
			echo '<td><a href="/'.$base.'/thread/update/'.$thread->getThreadId().'">Update</a></td></tr>';
		}
		echo "</tbody>";
		echo '</table>';
		echo '</div>';
		echo '</div>';
	}
	
  public static function showDetails() {
	$thread = (array_key_exists('thread', $_SESSION))?$_SESSION['thread']:null;
  	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
  	$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?
  		$_SESSION['authenticatedUser']:null;
  	if (!is_null($thread)) {
  		echo '<div class="container">';
  		echo '<h2><p>Thread Id: '.$thread->getThreadId().'<p></h2>';
  		echo '<p>Submitter name: '.$thread->getSubmitterName().'<p>';
  		echo '<p>Thread Title: '.$thread->getThreadTitle().'<p>';
  		echo '<p>Thread: '.$thread->getThread().'<p>';
  		echo '</div>';
  	}
  	self::showAllComments();
  	if(!is_null($authenticatedUser))
  		self::showNewComment();
  	}

   public static function showNew(){
   		$_SESSION['headertitle'] = "Create a new thread";
   		$_SESSION['styles'] = array('jumbotron.css');
   		MasterView::showHeader();
   		MasterView::showNavbar();
   		
	  	$thread = (array_key_exists('thread', $_SESSION))?$_SESSION['thread']:null;
	  	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
	   
	   echo '<div class="container-fluid">';
	   echo '<div class="row">';
	   echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
	   echo '<div class="col-md-6 col-sm-8 col-xs-10">';
	   echo '<h1>'.$_SESSION['headertitle'].'</h1>';

	   echo '<form role="form" method="post" action="/'.$base.'/thread/new">';
	   
	   // Error at the top of the form
	   if (!is_null($thread) && !empty($thread->getError('threadId'))) {
	     	echo  '<div class="form-group">';
	   	    echo  '<label><span class="label label-danger">';
	   		echo  $thread->getError('threadId');
	   	    echo '</span></label></div>';
	   }
	  
	   echo  '<div class="form-group">';
	   echo  '<label for="threadTitle">Thread Title: ';
	   echo '<span class="label label-danger">';
	   if (!is_null($thread))
	   		echo 'need title';
	   echo '</span></label>';
	   echo '<input type="text" class="form-control" id = "threadTitle" name="threadTitle"';
	   if (!is_null($thread))
	   		echo 'value = "'. $thread->getThreadTitle() .'"';
	   echo 'required>';
	   echo '</div>';
	   
	   echo '<div class="form-group">';
	   echo '<label for="threadBody">';
	   echo '<span class="label label-danger">';
	   if (!is_null($thread))
	   	  echo 'need thread body';
	   echo '</span></label>';
       echo '<textarea class="form-control" name="threadBody" id = "threadBody"
       		placeholder="Write your thread body here" rows="10" required>';
       if (!is_null($thread))
          echo $thread->getThread();
       echo '</textarea>';
       echo '</div>';
       
       echo '<button type="submit" class="btn btn-default">Submit</button>';
	   echo '</form>';
       echo '</div>';   
       echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
       echo '</div>';
	   echo '</div>';	
	   MasterView::showFooter();
	}
   	public static function showUpdate() {
   		$threads = (array_key_exists('threads', $_SESSION))?$_SESSION['threads']:null;
   		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
   		$_SESSION['headertitle'] = "DD update submission";
   		MasterView::showHeader();
   	
   		echo '<h1>DD Thread update</h1>';
   		if (is_null($threads) || empty($threads) || is_null($threads[0])) {
   			echo '<section>Thread does not exist</section>';
   			return;
   		}
   		$thread = $threads[0];
   		if ($thread->getErrors() > 0) {
   			$errors = $thread->getErrors();
   			echo '<section><p>Errors:<br>';
   			foreach($errors as $key => $value)
   				echo $value . "<br>";
   			echo '</p></section>';
   		}
   		echo '<section>';
   		echo '<h3>Thread information:</h3>';
   		echo 'Submitter name: '.$thread->getSubmitterName().'<br>';
   		echo 'Thread Id: '.$thread->getThreadId().'<br>';
   		echo '<form enctype="multipart/form-data" action ="/'.$base.'/thread/update" method="Post">';
   		echo '<input type="hidden" name="MAX_FILE_SIZE" value="500000" />';
   		 
   		echo '<input type="submit" value="Submit" />';
   		echo '</form>';
   		$_SESSION['footertitle'] = "The thread update footer";
   		MasterView::showFooter();
   	}
   	public static function showAllHome(){
   		$_SESSION['threads'] = ThreadDB::getThreadsBy();
   		$threads = (array_key_exists('threads', $_SESSION))?$_SESSION['threads']:null;
   		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
   		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?
   			$_SESSION['authenticatedUser']:null;
   		echo '<div class="container">';
   		echo '<h1></h1>';
   		echo '<div class="table-responsive">';
   		echo '<table class="table table-striped">';
   		echo "<thead>";
   		if(!is_null($authenticatedUser))
   			echo '<a href="/'.$base.'/thread/new">New Thread</a>';
   		echo "<tr><th></th></tr>";
   		echo "</thead>";
   		echo "<tbody>";
   		$threads = array_reverse($threads);
   		foreach($threads as $thread) {
   			echo '<tr><td>'.$thread->getThreadId().'</td>';
   			echo '<td><a href="/'.$base.'/thread/show/'.$thread->getThreadId().'">'.$thread->getThreadTitle().'</a>';
   			echo '<td>submitted by '.$thread->getSubmitterName().'</td></tr>';
   		}
   		echo "</tbody>";
   		echo '</table>';
   		echo '</div>';
   		echo '</div>';
   	}
   	public static function showAllComments(){
   		$comments = (array_key_exists('comments', $_SESSION))?$_SESSION['comments']:array();
   		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
   		$thread = (array_key_exists('thread', $_SESSION))?$_SESSION['thread']:null;
   		$comments = CommentDB::getCommentsBy('threadRef', $thread->getThreadId());
   		
   		echo '<div class="container">';
   		echo '<h1></h1>';
   		echo '<div class="table-responsive">';
   		echo '<table class="table table-striped">';
   		echo "<thead>";
   		echo "<tr><th></th></tr>";
   		echo "</thead>";
   		echo "<tbody>";
   		foreach($comments as $comment) {
   			echo '<tr><td>'.$comment->getComment().'</td></tr>';
   		}
   		echo "</tbody>";
   		echo '</table>';
   		echo '</div>';
   		echo '</div>';
   	}
   	public static function showNewComment(){
   		$thread = (array_key_exists('thread', $_SESSION))?$_SESSION['thread']:null;
   		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
   		$comment = (array_key_exists('comment', $_SESSION))?$_SESSION['base']:"";
   		echo '<div class="container-fluid">';
   		echo '<div class="row">';
   		echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
   		echo '<div class="col-md-6 col-sm-8 col-xs-10">';
   		echo '<h1></h1>';
   		
   		echo '<form role="form" method="post" action="/'.$base.'/comment/new/'.$thread->getThreadId().'">';
   		
   		// Error at the top of the form
   		if (!is_null($thread) && !empty($thread->getError('threadId'))) {
   			echo  '<div class="form-group">';
   			echo  '<label><span class="label label-danger">';
   			echo  $thread->getError('threadId');
   			echo '</span></label></div>';
   		}
   		 
   		
   		echo '<div class="form-group">';
   		echo '<label for="comment">';
   		echo '<span class="label label-danger">';
   		echo '</span></label>';
   		echo '<textarea class="form-control" name="comment" id = "comment"
       		placeholder="Write your comment here" rows="10" required>';
   		echo '</textarea>';
   		echo '</div>';
   		 
   		echo '<button type="submit" class="btn btn-default">Submit</button>';
   		echo '</form>';
   		echo '</div>';
   		echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
   		echo '</div>';
   		echo '</div>';
   	}
 }