<?PHP
    class DocumentsModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'D_id','P_id','R_id','LF_id','U_id','D_name','D_size','D_type','D_note','D_path','C_date','_pk' => 'D_id', '_autoinc' => true
        );
		
		protected $_validate = array(
			array('D_name','require','文档名称己存在!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }