<?PHP
    class ProjectModel extends Model {
		// �ֶ����� ���ֶ�
		protected $fields = array(
            'P_id','L_id','U_id','P_name','P_note','C_date','_pk' => 'P_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('P_name','require','��Ŀ���Ƽ�����!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }