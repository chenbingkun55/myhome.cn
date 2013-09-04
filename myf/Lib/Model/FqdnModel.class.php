<?PHP
    class FqdnModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'N_id','P_id','R_id','LF_id','U_id','S_id','N_name','N_FQDN','C_date','_pk' => 'N_id', '_autoinc' => true
        );

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }