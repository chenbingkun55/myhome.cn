<?PHP
	class FormAction extends Action{
		 public function insert(){
			$Form   =   D('Form');
			$data['title'] = 'ThinkPHP';
			$data['content'] = '������';
			//$Form->add($data);
		}
    }