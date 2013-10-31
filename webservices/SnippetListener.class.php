<?php
require_once("../core/Snippet.class.php");
require_once("WebService.class.php");

class SnippetListener extends WebService{
	//fetch action from database
	public function retrieve(){
		$id = intval($this->req('id'));
		$obj = Snippet::retrieve($id);
		if($obj != null){
			echo $obj->toXML();
		}
		else{
			die(err("No snippet found"));
		}
	}
	/*
	snippetID;
  	questionID;
  	url;
  	title;
  	snippet;
  	note;
  	type;
  	*/
	public function create(){
		$obj = new Snippet();		
		$url = $this->req("url");
		$title = $this->req("title");
		$snippet = $this->req("snippet");
		$note = $this->req("note");
		$obj->setUrl($url);
		$obj->setTitle($title);
		$obj->setSnippet($snippet);
		$obj->setNote($note);
		$obj->save();
		//return the new object
		echo $obj->toXML();
	}
	public function delete(){
		$id = intval($this->req('id'));
		$result = Snippet::delete($id);
		if($result == 0){
			err("Nothing was deleted");
		}
		else{
			feedback("Deleted");
		}
	}
	public function update(){
		$id = intval($this->req('id'));
		$obj = Snippet::retrieve($id);
	}
}