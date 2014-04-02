<?PHP
    class LocationModel extends Model {
		// �ֶ����� ���ֶ�
		protected $fields = array(
            'L_id','U_id','L_name','L_note','C_date','_pk' => 'L_id', '_autoinc' => true
        );

		protected $_validate = array(
			array('L_name','require','λ�����Ƽ�����!',0,'unique',1),
		);

		protected $_auto = array ( 
			array('C_date','time',2,time()),
		);
    }