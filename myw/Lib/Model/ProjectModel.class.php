<?PHP
    class ProjectModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'P_id','L_id','U_id','P_name','P_note','C_date','_pk' => 'P_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('P_name','require','项目名称己存在!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }