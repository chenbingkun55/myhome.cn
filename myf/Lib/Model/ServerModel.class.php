<?PHP
    class ServerModel extends Model {
		// �ֶ����� ���ֶ�
		protected $fields = array(
            'S_id','P_id','R_id','LF_id','U_id','S_name','S_base','S_title_conten','C_date', '_pk' => 'S_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('S_name','','���������Ƽ�����!',0,'unique',1),
		);
    }