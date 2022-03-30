<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// get dd
if (!function_exists('dd')) {
	function dd($value = null)
	{
		if (!empty($value)) {
			echo '<pre style="color: #fff; background: #000; padding: 10px; border-radius: 4px;">';
			print_r($value);
			die();
			echo '</pre>';
		}
		return false;
	}
}

// get get_hash
if (!function_exists('get_hash')) {
    function get_hash($value = null)
    {
        if (!empty($value)) {
            return hash('md5', $value . config_item('encryption_key'));
        }
    }
}

// get encode
if (!function_exists('get_encode')) {
    function get_encode($value = null, $formate = '')
    {
        if (!empty($value)) {
            if (!empty($formate)) {
                return $formate($value);
            } else {
                return base64_encode($value);
            }
        }
        return false;
    }
}

// get decode
if (!function_exists('get_decode')) {
    function get_decode($value = null, $formate = '')
    {
        if (!empty($value)) {
            if (!empty($formate)) {
                return $formate($value);
            } else {
                return base64_decode($value);
            }
        }
        return false;
    }
}

// get date
if (!function_exists('get_date')) {
    function get_date($date_formate, $date = null)
    {
        if (!empty($date)) {
            return date($date_formate, strtotime($date));
        } else {
            return date($date_formate);
        }
        return false;
    }
}

// get time
if (!function_exists('get_time')) {
    function get_time($time_formate, $time = null)
    {
        if (!empty($time)) {
            return date($time_formate, strtotime($time));
        } else {
            return date($time_formate);
        }
        return false;
    }
}
// get date_time
if (!function_exists('get_date_time')) {
    function get_date_time($date_time_formate, $date_time = null)
    {
        if (!empty($date_time)) {
            return date($date_time_formate, strtotime($date_time));
        } else {
            return date($date_time_formate);
        }
        return false;
    }
}


// get voucher code
if (!function_exists('get_voucher')) {
    function get_voucher($id, $digite = 6, $prefix = null)
    {
        if (!empty($id)) {
            if (!empty($prefix)) {
                $counter = $prefix . date('ymd') . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            } else {
                $counter = date('ymd') . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            }
        }
        return false;
    }
}

// get code
if (!function_exists('get_code')) {
    function get_code($id, $digite = 3, $prefix = null)
    {
        if (!empty($id)) {
            if (!empty($prefix)) {
                $counter = $prefix . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            } else {
                $counter = str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            }
        }
        return false;
    }
}


// get code
if (!function_exists('get_code_table')) {
    function get_code_table($table, $where = [], $digite = 3)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($table)) {

            if (!empty($where)) {
                $ci->db->where($where);
            }

            $total_row = $ci->db->count_all_results($table);

            $counter = str_pad(++$total_row, $digite, 0, STR_PAD_LEFT);
            return $counter;
        }
        return false;
    }
}

// save data
if (!function_exists('save_data')) {
    function save_data($table, $data = [], $where = [], $action = false)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($table) && !empty($data)) {
            if (!empty($where)) {
                $ci->db->where($where);
                $ci->db->update($table, $data);
                return true;
            } else {
                if ($action) {
                    $ci->db->insert($table, $data);
                    return $ci->db->insert_id();
                } else {
                    $ci->db->insert($table, $data);
                    return true;
                }
            }
        }
        return false;
    }
}


// delete data
if (!function_exists('delete_data')) {
    function delete_data($table, $where = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();
        if (!empty($table) && !empty($where)) {
            $ci->db->where($where);
            $ci->db->delete($table);
            return true;
        }
        return false;
    }
}


// convert number
if (!function_exists('convert_number')) {
    function convert_number($input_number, $convert_language = 'bn')
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        if ($convert_language == 'bn') {
            return str_replace($en, $bn, $input_number);
        } else {
            return str_replace($bn, $en, $input_number);
        }
        return false;
    }
}


// get last data
if (!function_exists('get_last')) {
    function get_last($table, $where = null, $select = null, $order_by = 'id desc', $limit = 1)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($table)) {

            // select column
            if (!empty($select)) {
                $ci->db->select($select);
            }
			
			// where cond
            if (!empty($where)) {
                $ci->db->where($where);
            }

            // order column
            if (!empty($order_by)) {
                $ci->db->order_by($order_by);
            }

            // limit data
            $ci->db->limit($limit);

			if($limit > 1){
				$query = $ci->db->get($table)->result();
			}else{
				$query = $ci->db->get($table)->row();
			}

            return $query;
        }
        return false;
    }
}

// get first data
if (!function_exists('get_first')) {
    function get_first($table, $where = [], $select = null, $order_by = 'id asc', $limit = 1)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($table)) {

            // select column
            if (!empty($select)) {
                $ci->db->select($select);
            }
			
			// where cond
            if (!empty($where)) {
                $ci->db->where($where);
            }

            // order column
            if (!empty($order_by)) {
                $ci->db->order_by($order_by);
            }

            // limit data
            $ci->db->limit($limit);
			
			if($limit > 1){
				$query = $ci->db->get($table)->result();
			}else{
				$query = $ci->db->get($table)->row();
			}

            return $query;
        }
        return false;
    }
}


// get row
if (!function_exists('get_row')) {
    function get_row($table, $where = [], $select = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($where)) {

            // get select column
            if (!empty($select)) {
                $ci->db->select($select);
            }

            $query = $ci->db->where($where)->get($table);

            return $query->row();
        }
        return false;
    }
}

// get name
if (!function_exists('get_name')) {
    function get_name($table, $select_column = null, $where = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($table) && !empty($select_column) && !empty($where)) {

            // get select column
            $ci->db->select($select_column);
            $ci->db->where($where);

            $query = $ci->db->get($table);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result->$select_column;
            }

            return false;
        }

        return false;
    }
}

// get all data
if (!function_exists('get_result')) {
    function get_result($table, $where = null, $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null, $not_like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($table)) {
            // select column
            if (!empty($select)) {
                $ci->db->select($select);
            }

            //get where
            if (!empty($where)) {
                $ci->db->where($where);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }
			
			// get like
            if(!empty($like)){
                $ci->db->like($like);
            }
            
            // get not like
            if(!empty($not_like)){
                $ci->db->not_like($not_like);
            }

            // get query
            $query = $ci->db->get($table);
            return $query->result();
        }
        return false;
    }
}


// get join all data
if (!function_exists('get_join')) {
    function get_join($tableFrom, $tableTo, $joinCond, $where = [], $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null, $not_like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            $ci->db->from($tableFrom);

            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key]);
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond);
                }
            }

            // get where
            if (!empty($where)) {
                $ci->db->where($where);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }
			
			// get like
            if(!empty($like)){
                $ci->db->like($like);
            }
            
            // get not like
            if(!empty($not_like)){
                $ci->db->not_like($not_like);
            }

            // get query
            $query = $ci->db->get();
            return $query->result();

        } else {
            return false;
        }
    }
}

// get left join all data
if (!function_exists('get_left_join')) {
    function get_left_join($tableFrom, $tableTo, $joinCond, $where = [], $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            // get table form
            $ci->db->from($tableFrom);

            // get join
            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key], 'left');
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond, 'left');
                }
            }

            // get where
            if (!empty($where)) {
                $ci->db->where($where);
            }
			
			// get like
            if(!empty($like)){
                $ci->db->like($like);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }

            // get query
            $query = $ci->db->get();
            return $query->result();

        } else {
            return false;
        }
    }
}


// get row join
if (!function_exists('get_row_join')) {
    function get_row_join($tableFrom, $tableTo, $joinCond, $where = [], $select = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();


        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond) && !empty($where)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            $ci->db->from($tableFrom);

            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key]);
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond);
                }
            }

            $ci->db->where($where);

            // get query
            $query = $ci->db->get();
            return $query->row();
        }
        return false;
    }
}


// get pagination
if (!function_exists('get_pagination')) {
    function get_pagination($pag_query = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        if (array_key_exists('select', $pag_query)) {
            $CI->db->select($pag_query['select']);
        }

        if (array_key_exists('where', $pag_query)) {
            $CI->db->where($pag_query['where']);
        }

        $search = '';
        unset($_GET['system_id']);
        if (!empty($_GET)) {
            $CI->db->where($_GET);

            $search .= '?';

            $i     = 1;
            $count = count($_GET);
            foreach ($_GET as $_key => $s_value) {
                if ($count == 1) {
                    $search .= $_key . '=' . $s_value;
                } else {
                    if ($i != $count) {
                        $search .= $_key . '=' . $s_value . '&';
                    } else {
                        $search .= $_key . '=' . $s_value;
                    }
                    $i++;
                }
            }
        }

        $total_row = $CI->db->count_all_results($pag_query['table']);
        
        if (array_key_exists('per_page', $pag_query)) {
            $per_page = $pag_query['per_page'];
        } else {
            $per_page = 10;
        }
        
        // pagination config
        $config               = [];
        $config["base_url"]   = base_url() . $pag_query['url'] . '/';
        $config["total_rows"] = $total_row;
        $config["per_page"]   = $per_page;
        $config['suffix']     = $search;
        
        // pagination template
        $config['full_tag_open']   = '<ul class="newPagination">';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = 'First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = '»';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '«';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="active">';
        $config['cur_tag_close']   = '</li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        

        // initialize pagination
        $CI->pagination->initialize($config);

        $page = ($CI->uri->segment($pag_query['segment'])) ? $CI->uri->segment($pag_query['segment']) : 0;

        $return_data["links"] = $CI->pagination->create_links();


        if (array_key_exists('where', $pag_query)) {
            $CI->db->where($pag_query['where']);
        }

        if (!empty($_GET)) {
            $CI->db->where($_GET);
        }

        $CI->db->limit($per_page, $page); 

        $query = $CI->db->get($pag_query['table']);
        

        if ($query->num_rows() > 0) {
            $return_data['results'] = $query->result();
            return $return_data;
        }
        return false;
    }
}

// get sum
if (!function_exists('get_sum')) {
    function get_sum($table, $column, $where = [], $groupBy = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($where) && $ci->db->field_exists($column, $table)) {
            //get data from databasea
            $ci->db->select_sum($column);
            $ci->db->where($where);
            //get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }
            $query = $ci->db->get($table);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result->$column;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }
}

// custom query
if (!function_exists('custom_query')) {
    function custom_query($query = null, $return_type = false, $action = true)
    {
        //get main CodeIgniter object
        $ci =& get_instance();
        //get data from databasea
        if (!empty($query) && $action == true) {

            if ($return_type) {
                return $ci->db->query($query)->row();
            } else {
                return $ci->db->query($query)->result();
            }
        } else if (!empty($query) && $action == false) {

            return $ci->db->query($query);
        }
        return false;
    }
}

// get filter
if (!function_exists('get_filter')) {
    function get_filter($input_string = null)
    {
        if (!empty($input_string)) {
            $input_string = str_replace("_", " ", $input_string);
            if (mb_detect_encoding($input_string) != 'UTF-8') {
                $result = ucwords($input_string);
            } else {
                $result = $input_string;
            }

            return $result;
        }
        return false;
    }
}

// get supplier client
if (!function_exists('get_supplier_balance')) {
    function get_supplier_balance($party_code = null, $tran_id = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($party_code)) {

            // define default variable
            $initital_balance = $debit = $credit = $balance = 0;

            // get party info
			if(!empty($tran_id)){
				$info = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit FROM ( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='supplier' AND trash=0 )parties LEFT JOIN ( SELECT party_code, sum(debit + remission) AS debit, SUM(credit) AS credit FROM partytransaction WHERE id < '$tran_id' AND trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();
			}else{
				$info = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit FROM ( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='supplier' AND trash=0 )parties LEFT JOIN ( SELECT party_code, sum(debit + remission) AS debit, SUM(credit) AS credit FROM partytransaction WHERE trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();
			}

            $initital_balance = (!empty($info->initial_balance) ? $info->initial_balance : 0);
            $debit            = (!empty($info->debit) ? $info->debit : 0);
            $credit           = (!empty($info->credit) ? $info->credit : 0);

            // get balance
            if ($initital_balance < 0) {
                $balance = $debit - (abs($initital_balance) + $credit);
            } else {
                $balance = ($initital_balance + $debit) - $credit;
            }

            $data['code']            = $info->code;
            $data['name']            = $info->name;
            $data['initial_balance'] = $initital_balance;
            $data['debit']           = $debit;
            $data['credit']          = $credit;
            $data['balance']         = $balance;
            $data['status']          = ($balance <= 0 ? "Payable" : "Receivable");

        } else {

            $data['code']            = '';
            $data['name']            = '';
            $data['initial_balance'] = 0;
            $data['debit']           = 0;
            $data['credit']          = 0;
            $data['balance']         = 0;
            $data['status']          = "Receivable";
        }

        return $data;
    }
}

// get cash client
if (!function_exists('get_client_balance')) {
    function get_client_balance($party_code = null, $tran_id = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();
		
		$data = [];

        if (!empty($party_code)) {

            // get party info
			if(!empty($tran_id)){
				$info = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit FROM( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='client' AND trash=0)parties LEFT JOIN ( SELECT party_code, sum(debit) AS debit, SUM(credit + remission) AS credit FROM partytransaction WHERE id < '$tran_id' AND trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();
			}else{
				$info = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit FROM( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='client' AND trash=0)parties LEFT JOIN ( SELECT party_code, sum(debit) AS debit, SUM(credit + remission) AS credit FROM partytransaction WHERE trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();
			}

            $initital_balance = (!empty($info->initial_balance) ? $info->initial_balance : 0);
            $debit            = (!empty($info->debit) ? $info->debit : 0);
            $credit           = (!empty($info->credit) ? $info->credit : 0);

            // get balance
            if ($initital_balance < 0) {
                $balance = $debit - (abs($initital_balance) + $credit);
            } else {
                $balance = ($initital_balance + $debit) - $credit;
            }

            $data['code']            = $info->code;
            $data['name']            = $info->name;
            $data['initial_balance'] = $initital_balance;
            $data['debit']           = $debit;
            $data['credit']          = $credit;
            $data['balance']         = $balance;
            $data['status']          = ($balance < 0 ? "Payable" : "Receivable");

        } else {

            $data['code']            = '';
            $data['name']            = '';
            $data['initial_balance'] = 0;
            $data['debit']           = 0;
            $data['credit']          = 0;
            $data['balance']         = 0;
            $data['status']          = "Receivable";
        }

        return $data;
    }
}

// get cash client balance
if (!function_exists('get_voucher_due')) {
    function get_voucher_due($voucher_no = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($voucher_no)) {

            // define default variable
            $debit = $credit = $balance = 0;

            // get party info
            $info = $ci->db->query("SELECT saprecords.voucher_no, partytransaction.debit, partytransaction.credit FROM (SELECT party_code, voucher_no FROM saprecords WHERE voucher_no='$voucher_no' AND trash=0 )saprecords LEFT JOIN ( SELECT party_code, sum(debit) AS debit, SUM(credit + remission) AS credit FROM partytransaction WHERE trash=0 AND relation IN ('sales:$voucher_no', '$voucher_no') )partytransaction ON saprecords.party_code=partytransaction.party_code")->row();

            $debit  = (!empty($info->debit) ? $info->debit : 0);
            $credit = (!empty($info->credit) ? $info->credit : 0);

            $due = $debit - $credit;

            $data['voucher_no'] = $info->voucher_no;
            $data['debit']      = $debit;
            $data['credit']     = $credit;
            $data['due']        = $due;

        } else {

            $data['voucher_no'] = '';
            $data['credit']     = 0;
            $data['debit']      = 0;
            $data['due']        = 0;
        }

        return $data;
    }
}

// get max value
if (!function_exists('get_max')) {
    function get_max($table, $column, $where = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        //get data from databasea
        if (!empty($where) && $ci->db->field_exists($column, $table)) {
            //get data from databasea
            $ci->db->select_max($column);
            $ci->db->where($where);
            $query = $ci->db->get($table);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result->$column;
            } else {
                return 0.00;
            }
        } else {
            return false;
        }
    }
}


// file upload
if (!function_exists('file_upload')) {
    function file_upload($fileName, $upload_path = "", $file_type = null, $prefix = "")
    {
        if ($_FILES[$fileName]["name"] != null or $_FILES[$fileName]["name"] != "" && !empty($upload_path)) {

            // check upload folder if not exists create folder
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0777, true)) {
                    die('Failed to create folders...');
                }
            }

            //$fileName = get_clear_str(get_slug($_FILES[$fileName]["name"]));

            if (!empty($file_type)) {
                $f_type = $file_type;
            } else {
                $f_type = 'png|jpeg|jpg|gif';
            }
            $config                  = [];
            $config['upload_path']   = './' . $upload_path;
            $config['allowed_types'] = $f_type;
            $config['max_size']      = '5120';
            $config['max_width']     = '2560';
            $config['max_height']    = '2045';
            $config['file_name']     = (!empty($prefix) ? $prefix . '-' : ''). get_clear_str(get_slug($_FILES[$fileName]["name"])) . '-' . floor(microtime(true));
            $config['overwrite']     = true;

            $ci = &get_instance();
            $ci->upload->initialize($config);

            if ($ci->upload->do_upload($fileName)) {
                $upload_data = $ci->upload->data();

                $filePath = $upload_path . '/' . $upload_data['file_name'];

                return $filePath;
            } else {
                return false;
            }
        }
    }
}
 
// remove special character 
if (!function_exists('get_clear_str')) {
	function get_clear_str($string) {
	   $string = str_replace(' ', '-', $string);

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
}

// get resize image
if (!function_exists('resize_image')) {
    function resize_image($input_field_name, $max_width, $max_height, $upload_path = 'public/upload', $index = null, $prefix = null, $time = null)
    {
        if(!empty($_FILES["$input_field_name"]) && !empty($max_width) && !empty($max_width)){
            
			// check upload folder if not exists create folder
            if(!is_dir($upload_path)){
                if (!mkdir($upload_path, 0777, true)) {
                    die('Failed to create folders...');
                }
            }
            
            if(!is_array($_FILES["$input_field_name"]['name'])){
                $filePath = $_FILES["$input_field_name"]["tmp_name"];
                $fileName = strtolower(pathinfo($_FILES["$input_field_name"]["name"], PATHINFO_FILENAME));
                $fileExtension = strtolower(pathinfo($_FILES["$input_field_name"]["name"], PATHINFO_EXTENSION));
            }else{
                $filePath = $_FILES["$input_field_name"]["tmp_name"][$index];
                $fileName = strtolower(pathinfo($_FILES["$input_field_name"]["name"][$index], PATHINFO_FILENAME));
                $fileExtension = strtolower(pathinfo($_FILES["$input_field_name"]["name"][$index], PATHINFO_EXTENSION));
            };
            
            list($orig_width, $orig_height) = getimagesize($filePath);

            $width = $orig_width;
            $height = $orig_height;

            # taller
            if ($height > $max_height) {
                $width = ($max_height / $height) * $width;
                $height = $max_height;
            }

            # wider
            if ($width > $max_width) {
                $height = ($max_width / $width) * $height;
                $width = $max_width;
            }

            // allowed file extension
            $allowedExtension = ['gif', 'jpg', 'jpeg', 'png'];  

            if (!in_array($fileExtension, $allowedExtension)) {
                return false;
            } 
        
            // convert image
            switch ($fileExtension) {
                case 'gif' :
            $image = imageCreateFromGif($filePath);
                break;
                case 'png' :
            $image = imageCreateFromPng($filePath);
                break;
                case 'jpg':
                case 'jpeg':
            $image = imageCreateFromJpeg($filePath);
                break;
            }

            // resize image
            $image_p = imagecreatetruecolor($width, $height);

            imagepalettetotruecolor($image_p);
            imagealphablending($image_p, true);
            imagesavealpha($image_p, true);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

            // create file name
            $image_name = (!empty($prefix) ? "$prefix-" : "") . clean_text($fileName) .'-'. date('Ymd') . (!empty($time) ? $time : time()) .'.webp';

            // upload file
            imagewebp($image_p, "./$upload_path/$image_name", 50);
            //imagedestroy($image_p);

            return $image_name;
        }

        return false;
    }
}


// get input data
if (!function_exists('input_data')) {
    function input_data($input_name = null)
    {
        if (!empty($input_name)) {
            if (is_array($input_name)) {
                $new_data = [];
                foreach ($input_name as $val) {
                    $input          = !empty($_POST[$val]) ? $_POST[$val] : '';
                    $new_data[$val] = htmlspecialchars(trim($input));
                }
                return $new_data;
            } else {
                $input = !empty($_POST[$input_name]) ? $_POST[$input_name] : '';
                return htmlspecialchars(trim($input));
            }
        }
        return false;
    }
}

// check exists
if (!function_exists('check_exists')) {
    function check_exists($table, $where = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($table) && !empty($where)) {

            $ci->db->where($where);
            $query = $ci->db->get($table);
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


// check null
if (!function_exists('check_null')) {
    function check_null($input_data = null)
    {
        if (!empty($input_data) && $input_data !== '') {
            return $input_data;
        } else {
            return 'N/A';
        }
    }
}

// check auth
if (!function_exists('checkAuth')) {
    function checkAuth($privilege = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($privilege)) {
            if ($ci->data['privilege'] == $privilege) {
                return true;
            }
            return false;
        }
        return false;
    }
}

// get all godown
if (!function_exists('getAllGodown')) {
    function getAllGodown($select = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        // get select column
        if (!empty($select)) {
            $ci->db->select($select);
        }

        $query = $ci->db->get('godowns');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

// get number formate
if (!function_exists('get_number_format')) {
    function get_number_format($number = null, $decimal = 2)
    {
        if (!empty($number)) {
            return number_format($number, $decimal);
        }
        return 0;
    }
}

// get previous balance
if (!function_exists('get_previous_balance')) {
    function get_previous_balance($voucher_no = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($voucher_no)) {
            
            // get transaction info
            $tranInfo = $ci->db->query("SELECT id, credit, debit FROM partytransaction WHERE relation='sales:$voucher_no' AND trash=0")->row();
            $saleInfo = $ci->db->query("SELECT id, party_code, voucher_no FROM saprecords WHERE voucher_no='$voucher_no' AND trash=0")->row();
            
            // get party info
            $info = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit, saprecords.total_cost FROM( SELECT code, name, initial_balance FROM parties WHERE code='$saleInfo->party_code' AND type ='client' AND trash=0)parties LEFT JOIN ( SELECT party_code, sum(debit) AS debit, SUM(credit + remission) AS credit FROM partytransaction WHERE id < $tranInfo->id AND trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code LEFT JOIN (SELECT party_code, SUM(others_cost) AS total_cost FROM saprecords WHERE id < '$saleInfo->id' AND trash=0 GROUP BY party_code)saprecords ON parties.code=saprecords.party_code")->row();
            
            $initital_balance = (!empty($info->initial_balance) ? $info->initial_balance : 0);
            $debit            = (!empty($info->debit) ? $info->debit : 0);
            $credit           = (!empty($info->credit) ? $info->credit : 0);
            $total_cost       = (!empty($info->total_cost) ? $info->total_cost : 0);

            // get balance
            if ($initital_balance < 0) {
                $balance = ($debit + $total_cost) - (abs($initital_balance) + $credit);
            } else {
                $balance = ($initital_balance + $debit + $total_cost) - $credit;
            }

            $data['code']            = $info->code;
            $data['name']            = $info->name;
            $data['initial_balance'] = $initital_balance;
            $data['debit']           = $debit;
            $data['credit']          = $credit;
            $data['balance']         = $balance;
            $data['status']          = ($balance < 0 ? "Payable" : "Receivable");

        } else {

            $data['code']            = '';
            $data['name']            = '';
            $data['initial_balance'] = 0;
            $data['debit']           = 0;
            $data['credit']          = 0;
            $data['balance']         = 0;
            $data['status']          = "Receivable";
        }

        return $data;
    }
}

// get slug
if (!function_exists('get_slug')) {
    function get_slug($input_data = null, $replace = '_')
    {
		if(!empty($input_data)){
			return str_replace(' ', $replace, strtolower(trim($input_data)));
		}
		
		return false;
	}
}

if (!function_exists('get_quantity')) {
    function get_quantity($input_value = null, $pack_size = 0)
    {
        $data = [];
        if (!empty($input_value) && $pack_size > 0 && $input_value > 0) {

            $pcs  = $input_value % $pack_size;
            $qty  = $input_value - $pcs;
            $pack = floor($qty / $pack_size);

            $data['pack'] = $pack;
            $data['pcs']  = $pcs;

            return $data;
        } else {

            $data['pack'] = 0;
            $data['pcs']  = $input_value;

            return $data;
        }

        return false;
    }
}

if (!function_exists('strPrefix')) {
    function strPrefix($string = null, $prefix = '*', $length = 6) {
        if (!empty($string)) {
            $result = substr($string, 0, 3) . str_pad('', $length, $prefix, STR_PAD_LEFT) . substr($string, -3);
            return  $result;
        }
    }
}


// set site config file
//$config_data = get_result('tbl_config');
//if(!empty($config_data)){
//    foreach($config_data as $c_value){
//        $this->config->set_item($c_value->config_key, $c_value->config_value);
//    }
//}