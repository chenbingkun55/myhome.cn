<?PHP
    class OtheModel extends Model {
		// �ֶ����� ���ֶ�
		protected $fields = array(
            'O_id','P_id','R_id','LF_id','U_id','O_name','O_text','C_date','_pk' => 'O_id', '_autoinc' => true
        );

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }