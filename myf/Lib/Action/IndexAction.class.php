<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function Index(){
		$work_account = M('account');


		
		$this->tdate = date("Y-m-d H:i");
		$this->username = $work_account->where("U_id=1" )->getField('U_name');
		/* 测试 JSON 功能.
			$work_server = M('server'); 
			$temp = json_encode($work_server->where("S_id=3" )->select());
			// print_r($temp);
			echo "<BR>";
			print_r(json_decode($temp, true)); // true 以数组方式输出.
			$temp = json_decode($temp, true);
			echo "<BR>TEST ".$temp[0]['S_note'];
		*/
		$this->title = "个人网络工作室";
		$this->display();
    }
}