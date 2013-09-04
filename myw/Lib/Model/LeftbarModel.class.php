<?PHP
    class LeftbarModel extends Model {
		// 手动定义 表字段
		protected $fields = array(
            'LF_id','P_id','R_id','U_id','LF_name','LF_note','_pk' => 'LF_id', '_autoinc' => true
        );
    }