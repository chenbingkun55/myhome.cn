<?PHP
    class ResourceModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'R_id','P_id','U_id','R_name','R_type','R_note','C_date','_pk' => 'R_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('R_name','require','位置名称己存在!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }