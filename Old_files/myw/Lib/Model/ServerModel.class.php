<?PHP
    class ServerModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'S_id','P_id','R_id','LF_id','U_id','S_name','S_base','S_title_conten','C_date', '_pk' => 'S_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('S_name','','服务器名称己存在!',0,'unique',1),
		);
    }