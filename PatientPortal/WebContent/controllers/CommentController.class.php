<?php
class CommentController {

	public static function run() {
       // Perform actions related to a submission
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
        switch ($action) {
        	case "new":
        		self::newComment($arguments);
        		ThreadView::show();
        		break;
        	case "edit":
        		self::editComment();
        		break;
        	default:
        		HomeView::show(null);
        }
	}

	public static function newComment($threadRef) {
		$comment = null;
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?
			$_SESSION['authenticatedUser']:null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$comment = new Comment($_POST);
			if (!is_null($authenticatedUser))
				$comment -> setSubmitterId($authenticatedUser->getUserId());
			else $comment -> setSubmitterId(0);
			$comment->setThreadRef($threadRef);
			$comment = CommentDB::addComment($comment);
		}
		if (is_null($comment) || $comment->getErrorCount() != 0) {
			$_SESSION['comment'] = $comment;
		} else {
			ThreadView::show();	
			header('Location: /'.$_SESSION['base']);
		}

	}
	
	public static function editComment() {
	}
	

}
?>