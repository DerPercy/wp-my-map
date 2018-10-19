<?php

class MyMapPoint {
  protected $lat;
  protected $lon;
  protected $title = "";
  protected $url = "";
  protected $imageUrl = "";
  
  function __construct($lat,$lon){
    $this->lat = $lat;
    $this->lon = $lon;
  }
  
  // Title
  public function setTitle($title){
    $this->title = $title;
  }

  public function getTitle(){
    return $this->title;
  }
  
  // Url
  public function setURL($url){
    $this->url = $url;
  }

  public function getURL(){
    return $this->url;
  }
  
  // Image URL
  public function setImageURL($url){
    $this->imageUrl = $url;
  }

  public function getImageURL(){
    return $this->imageUrl;
  }
  
  
  public function getLat(){
    return $this->lat;
  }

  public function getLon(){
    return $this->lon;
  }

}
