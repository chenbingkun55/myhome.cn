<?PHP
    class PasswordModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
		 'PA_id','P_id','R_id','LF_id','U_id','PA_disable','PA_name','PA_type','PA_pass','PA_note','PA_C_date','PA_E_date','C_date', '_pk' => 'PA_id', '_autoinc' => true
        );

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }