<?php

class TrafficManager extends MvcModel {

	var $display_field = 'name';
	var $table = "wp_traffic_managers_error_message";
	
  public function after_save($object) {
    $this->update_sort_name($object);
  }
  
  public function update_sort_name($object) {
  //  $sort_name = $object->name;
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