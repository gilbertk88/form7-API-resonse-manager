<?php

class TrafficLink extends MvcModel {

    var $display_field = 'url';
	var $table = "wp_traffic_managers_redirect_url";
	
	//var $selects = array('error_id', 'error_message', 'error_url');
	
	//public $hide_menu = false;
	
  public function after_save($object) {
    $this->update_sort_name($object);
  }
  
  public function update_sort_name($object) {
   // $sort_name = $object->name;
    $article = 'The';
    $article_ = $article.' ';
    if (strcasecmp(substr($sort_name, 0, strlen($article_)), $article_) == 0) {
      $sort_name = substr($sort_name, strlen($article_)).', '.$article;
    }
    $this->update($object->__id, array('sort_name' => $sort_name));
  }
  
   public function make_past_events_not_public() {
    $this->update_all(
      array('is_public' => 0),
      array('date <' => date('Y-m-d'))
    );
  }
  
}

?>