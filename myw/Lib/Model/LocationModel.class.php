<?PHP
    class LocationModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'L_id','U_id','L_name','L_note','C_date','_pk' => 'L_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('L_name','require','位置名称己存在!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }