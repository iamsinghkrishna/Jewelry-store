<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends MY_Model {

    public $_table = 'payments';
    public $primary_key = 'payment_id';
//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

}