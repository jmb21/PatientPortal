<?php
class ThreadController {

	public static function run() {
       // Perform actions related to a submission
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
        switch ($action) {
        	case "new":
        		self::newThread();
        		break;
        	case "show":
        		$threads = ThreadDB::getThreadsBy('threadId', $arguments);
        		$_SESSION['thread'] = (!empty($threads))?$threads[0]:null;
        		ThreadView::show();
        		break;
        	case "showall":
        		$_SESSION['threads'] = ThreadDB::getThreadsBy();
        		ThreadView::showall();
        		break;
        	case "update":
        		self::updateThread();
        		break;
        	default:
        }
	}

	public static function newThread() {
		$thread = null;
		$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?
			$_SESSION['authenticatedUser']:null;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$thread = new Thread($_POST);
			$thread -> setSubmitterName($authenticatedUser->getUserName());
			$thread = ThreadDB::addThread($thread);
		}
		if (is_null($thread) || $thread->getErrorCount() != 0) {
			$_SESSION['thread'] = $thread;
			ThreadView::showNew();
		} else {
			HomeView::show();	
			header('Location: /'.$_SESSION['base']);
		}

	}
	
	public static function updateThread() {
		// Process updating submissions
		$threads = ThreadDB::getThreadsBy('threadId', $_SESSION['arguments']);
		if (empty($threads)) {
			HomeView::show();
			header('Location: /'.$_SESSION['base']);
		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
			$_SESSION['thread'] = $threads[0];
			ThreadView::showUpdate();
		} else {
			$parms = $threads[0]->getParameters();
			$newThread = new Thread($parms);
			$newThread->setThreadId($threads[0]->getThreadId());
			$thread = ThreadDB::updateThread($newThread);
		
			if ($thread->getErrorCount() != 0) {
				$_SESSION['thread'] = $newThread;
				ThreadView::showUpdate();
			} else {
				HomeView::show();
				header('Location: /'.$_SESSION['base']);
			}
		}
	}
	

}
?>