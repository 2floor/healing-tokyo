<?php
session_start();
require_once __DIR__ .  '/../logic/common/common_logic.php';
$common_logic = new common_logic();

$where_p = array($_SESSION['jis']['login_member']['store_basic_id']);
$where = ' AND `tour_id` = ? ';
array_push($where_p,$_POST['tour_id']);
$order = 'ORDER BY `cancel_flg` ASC, `come_date` DESC';

$rsv = $common_logic->select_logic("
				SELECT `reservation_id`, `tour_relation_id`, `tour_id`, `title`, `start_date`, `start_time`,`cancel_flg`,`payment_way`, `men_num`, `women_num`, `children_num`, (`men_num` + `women_num` + `children_num` ) AS `total_num`, `total_add_tax`, `come_date`, `m`.`name`, `m`.`tel`
				FROM `t_reservation`
				INNER JOIN (
					SELECT `tour_relation_id`, `tour_id`, `title`, `start_date`, `start_time`
					FROM `t_tour_relation`
					INNER JOIN (
							SELECT `tour_id`, `title`
							FROM `t_tour`
					) AS `t` USING(`tour_id`)
				) AS `tr` USING(`tour_relation_id`)
				INNER JOIN (
					SELECT `member_id`, `name`, `tel`
					FROM `t_member`
				) AS `m` USING (`member_id`)
				WHERE `store_basic_id` = ?
						".$where."
				".$order."
				LIMIT 5 ", $where_p);


$csv_data = array(array(
		"No",
		"予約者名",
		"電話番号",
		"予約者数",
		"男性",
		"女性",
		"子供",
		"支払方法",
		"",
));

$no = 1;
$title = $rsv[0]['title'];
$date = date('Y-m-d', strtotime($rsv[0]['start_date']));
foreach ((array)$rsv as $row) {
	if(date('Y-m-d', strtotime($_POST['come_date'])) = date('Y-m-d', strtotime($_POST['start_date'])))continue;
	$pw = "クレジット払い";
	if($row["payment_way"] == 1){
		$pw = "現地払い";
	}
	$cn = "";
	if($row["cancel_flg"] == 1){
		$cn= "キャンセル";
	}
	$csv_data[] = array(
			$no,
			$row["name"],
			$row["tel"],
			$row["total_num"],
			$row["men_num"],
			$row["women_num"],
			$row["children_num"],
			$pw,
			$cn
	);
	$no++;
}

touch("test.csv");
$f = fopen("test.csv", "w");
if ( $f ) {
	foreach($csv_data as $line){
		fputcsv($f, $line);
	}
}
fclose($f);

header('Content-Type: application/force-download');
header('Content-Length: '.filesize('test.csv'));
header('Content-Disposition: attachment; filename="'.$date.'_'.$title.'.csv"');
readfile(__DIR__ . '/test.csv');