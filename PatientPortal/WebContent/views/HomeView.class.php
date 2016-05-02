<?php
class HomeView {
  public static function show() { 
  	  $_SESSION['headertitle'] = "Digital Diagnostics Home Page";
  	  $_SESSION['styles'] = array('jumbotron.css');
	  MasterView::showHeader();
	  MasterView::showNavbar();
	  HomeView::showDetails();
	  $_SESSION['footertitle'] = "<h3>The footer goes here</h3>";
	  MasterView::showHomeFooter();
      MasterView::showFooter();
  }

   public static function showDetails() {
      $base = $_SESSION['base'];
      echo '<div class="jumbotron">';
      echo '<div class="container">';
      ThreadView::showAllHome();
   }
}
?>