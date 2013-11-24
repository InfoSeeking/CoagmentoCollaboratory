<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Action.class.php');

/**
* @class Stage
* A stage is a logical step in a study. For example, a stage might be a task in which the user retrieves information to answer a single question. Then he/she moves onto the next stage in the study. Projects can have many stages in a study. Stages are ordered by their seqNum field.
*/
class Stage extends Base
{
	protected $seqNum;
	protected $currentPage;
	protected $maxTime;
	protected $maxQuestion;
	protected $maxLoops;
	protected $currentLoops;
	
	public function __construct(){
		$this->inDatabase = false;
	}


	//getters for this sessionprogress
	public function getCurrentSessionProgress(){return $this->seqNum;}
	public function getCurrentPage(){return $this->currentPage;}
	public function getMaxTime(){return $this->maxTime;}
	public function getMaxTimeQuestion(){return $this->maxTimeQuestion;}
	public function getAllowBrowsing(){return $this->allowBrowsing;}

	//SETTERS
	public function setPage($val){$this->page = $val;}
	public function setSeqNum($val){$this->seqNum = $val;}
	public function setMaxTime($val){$this->maxTime = $val;}
	public function setMaxTimeQuestion($val){$this->maxTimeQuestion = $val;}
	public function setMaxLoops($val){$this->maxLoops = $val;}
	public function setCurrentLoops($val){$this->currentLoops = $val;}
	public function setAllowBrowsing($val){$this->allowBrowsing = $val;}
}
?>