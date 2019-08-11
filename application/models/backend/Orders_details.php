<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_details extends MY_Model {

    public $_table = 'order_details';
    public $primary_key = 'ord_det_id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';
}

/* End of file Orders_details.php */
/* Location: ./models/backend/Orders_details.php */