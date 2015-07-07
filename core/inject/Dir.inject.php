<?php
class DirInject extends DIInject {
    
	private $urlInfo;
	public function __construct(){
		$this->urlInfo = $_SESSION['urlInfo'];
	}
	private function prevent(){
		echo "@ErrorAction";
		die;
	}
	//type值为real或virtual时，才可以接受参数
	public function beforeDirdir(){
		if( ! in_array(arg('type'), array('real', 'virtual'))){
			ErrorTips::url_param_doesnt_fit_the_shell("Dir->dirdir()");
			$this->prevent();
		}
	}
	//type值为virtual时，才可以接受参数
	public function beforeEmpdir(){
		if( strcasecmp(arg('type'), 'virtual') ){
			ErrorTips::url_param_doesnt_fit_the_shell("Dir->dirdir()");
			$this->prevent();
		}
	}
	//要求接收到的urlInfo['ids']!=null
	public function beforeRmdir(){
		if(null == arg('ids')){
			echo "请求错误，无id值<br>";
			$this->prevent();
		}
	}
}