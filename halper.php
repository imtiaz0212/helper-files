<?php

$party_balance = ($_POST['current_balance'] == 'Payable' ? '-' : ''). $_POST['current_balance'];

// get party transaction
$partyTran = custom_query("SELECT parties.code, SUM(IFNULL(partytransaction.debit, 0) - IFNULL(partytransaction.credit, 0) + parties.initial_balance) AS balance FROM ( SELECT code, initial_balance FROM parties WHERE code='$row->code' AND trash=0 )parties LEFT JOIN ( SELECT party_code, SUM(credit) AS credit, SUM(debit) AS debit FROM partytransaction WHERE trash=0 GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code", true);
if (!empty($partyTran)) {
	$balance = $partyTran->balance;
	$status  = ($partyTran->balance < 0 ? 'Payable' : 'Receivable');
} else {
	$balance = 0;
	$status  = 'Receivable';
}


function f_number($number, $point=2){
    $fmt = new \NumberFormatter('en_IN', NumberFormatter::DECIMAL);
    return $fmt->format(round($number, $point));
}

$dateParam = '2020-11-08';
$week = date('w', strtotime($dateParam));

$date = new DateTime($dateParam);
$firstWeek = $date->modify("-".$week." day")->format("Y-m-d");
$endWeek = $date->modify("+6 day")->format("Y-m-d");
echo $firstWeek."<br/>";
echo $endWeek;


$voucher_no = "sales:".$result->voucher_no;
$party_code = $result->party_code;
$tranInfo = custom_query("SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM partytransaction WHERE id < (SELECT id FROM partytransaction WHERE relation='$voucher_no') AND party_code='$party_code' AND trash=0", true);
$credit = (!empty($tranInfo->credit) ? $tranInfo->credit : 0);
$debit = (!empty($tranInfo->debit) ? $tranInfo->debit : 0);
$previous_balance = $result->initial_balance + $debit - $credit;
echo f_number($previous_balance);

$this->data['allGodown'] = getAllGodown();


if (isset($_POST['show'])) {

	if (!empty($_POST['search'])) {
		foreach ($this->input->post('search') as $key => $value) {
			if (!empty($value)) {
				$where['partytransaction.' . $key] = $value;
			}
		}
	}

	if (!empty($_POST['godown_code'])){
		if ($_POST['godown_code'] != 'all'){
			$where['partytransaction.godown_code'] = $_POST['godown_code'];
		}
	}else{
		$where['partytransaction.godown_code']    = $this->data['branch'];
	}

	if (!empty($_POST['dateFrom'])) {
		$where['partytransaction.transaction_at >='] = $_POST['dateFrom'];
		$where['partytransaction.transaction_at <='] = date('Y-m-d');
	}

	if (!empty($_POST['dateTo'])) {
		$where['partytransaction.transaction_at <='] = $_POST['dateTo'];
	}
} else {
	$where['partytransaction.transaction_at'] = date('Y-m-d');
	$where['partytransaction.godown_code']    = $this->data['branch'];
}





?>