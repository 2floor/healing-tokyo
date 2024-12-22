<?php
//ini_set('display_errors', "On"); 
session_start();
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';
class front_disp_logic {
    private $common_logic;
    private $jis_common_logic;

    public function __construct(){
        $this->common_logic = new common_logic();
        $this->jis_common_logic = new jis_common_logic();
    }

    public function get_news($cate){

        $news = $this->common_logic->select_logic("select * from t_news where del_flg = 0 and public_flg = 0 and disp_date <= CURDATE() and category = ? order by disp_date desc limit 5", array($cate));

        $tour_html = '';
        foreach ((array)$news as $row) {

            $tour_html .= '<a href="./news_detail.php?nid='.$row['news_id'].'">
								<div class="mypageInfoRow">
									<div class="mypageInfoDate">'.str_replace("-", ".", $row['disp_date']).'</div>
									<div class="mypageInfoTxt">
										'.mb_strimwidth($row['title'], 0, 50, "…", "UTF-8").'
									</div>
								</div>
							</a>';
        }

        if($tour_html == null || $tour_html == ''){
            if($cate == '1'){
                $tour_html = '<p>現在公開されているニュースはありません。</p>';
            }else{
                $tour_html = '<p>No news is currently available.</p>';
            }
        }


        return $tour_html;

    }




    public function get_my_tour(){
        $tour = $this->common_logic->select_logic("select * from t_tour where store_basic_id = ? and del_flg = 0", array($_SESSION['jis']['login_member']['store_basic_id']));

        $tour_html = '';
        foreach ((array)$tour as $row) {

	       	$offer = $this->common_logic->select_logic("select * from t_eng_offer where tour_id = ? order by create_at desc", array($row['tour_id']));
	       	$offer_str = '';
	       	if($offer != null && $offer != ''){
	       		if($offer[0]['status'] == '1'){
	       			$offer_str = '<br><span class="mypageStoreRelease now">翻訳完了</span>';
	       		}else{
	       			$offer_str = '<br><span class="mypageStoreRelease">翻訳申請中</span>';
	       		}
	       	}

	       	$price = $this->jis_common_logic->calc_discount($row['adult_fee'], $row['discount_rate_setting']);
		$ch_price = $this->change_rate($price);

	       	if($price != $row['adult_fee']){
			$adult_fee = $this->change_rate($row['adult_fee']);
			$price_str = '<span style="	text-decoration: line-through;text-align: left;margin-bottom: 10px;">'.$adult_fee.'</span>→'.$ch_price;
	       		//$price_str = '<span style="	text-decoration: line-through;text-align: left;margin-bottom: 10px;">'.number_format($row['adult_fee']).'円</span>→'.number_format($price) . "円";
	       	}else{
			$price_str = $ch_price;
	       		//$price_str = number_format($price) . '円';
	       	}


	       	$public_str = '<span class="mypageStoreRelease now">公開中</span>' .$offer_str;
            $public_ct = '<button type="button" class="mypageStoreInfoEditBtn2 public_tour" t="1" tid="'.$row['tour_id'].'">非公開</button>';
            if($row['public_flg'] == 1){
            	$public_str = '<span class="mypageStoreRelease">非公開</span>' .$offer_str;
                $public_ct = '<button type="button" class="mypageStoreInfoEditBtn2 public_tour" t="0" tid="'.$row['tour_id'].'">公開</button>';
            }



            $tour_html .= '<div class="mypageReservBox">
					<div class="mypageReservStoreRow">
						<div class="mypageReservDate">
							'.$public_str.'
						</div>
						<div class="mypageReservNameBox">
							<div class="mypageStoreInfoName">'.$row['title'].'</div>
							<p class="mypageStoreInfoTxt">
								'.$row['d_detail'].'
							</p>
						</div>
					</div>
					<div class="mypageStoreInfoBtmBox">
						<div class="mypageStoreInfoEditBtnBox">
							<button type="button" class="mypageStoreInfoEditBtn1"><a href="./edit.php?tid='.$row['tour_id'].'">編集</a></button>
							'.$public_ct.'
							<button type="button" class="mypageStoreInfoEditBtn2 del_tour" tid="'.$row['tour_id'].'">削除</button>
							<button type="button" class="mypageStoreInfoEditBtn1"><a href="./regist_tour.php?tid='.$row['tour_id'].'">copy</a></button>
							<button type="button" class="mypageStoreInfoEditBtn1 s2"><a href="./booking_list.php?tid='.$row['tour_id'].'">予約者一覧</a></button>
						</div>
						<div class="mypageStoreInfoPrice">'.$price_str.'</div>

					</div>
				</div>';
        }


        if ($tour_html == '') {
            $tour_html = '<p class="mypageTxt">
								まだ登録はありません
							</p>';
        }

        return $tour_html;

    }


    public function search_tour_html($get){


    	$disp_num = 40;

    	foreach ((array)$get as $ke => $gt) {
    		$get[$ke] = urldecode($gt);
    	}


    	$now_page = 0;
    	if($get['now'] != null && $get['now'] != ''){
    		$now_page = $get['now'];
    	}

        if ($get['date'] != '' && $get['date'] != null) {
            $date_array = explode("/", $get['date']);
            $get['date'] = $date_array[2]."-".$date_array[0]."-".$date_array[1];
        }

        $where ='';
        $where2 ='';
        $inner_join ='';
        $inner_join_where = '';
        $inner_join_col ='';
        $where_param1 = array();
        $where_param2 = array();
        $where_param3 = array();

        if($get['cate'] != null && $get['cate'] != ''){

        	$cate_ar = array($get['cate']);
        	$category_child = $this->common_logic->select_logic("select `category_id` from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 ", array($get['cate']));
        	foreach ((array)$category_child as $cc) {
        		array_push($cate_ar, $cc['category_id']);
        		$category_child_child = $this->common_logic->select_logic("select `category_id` from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 ", array($cc['category_id']));
        		foreach ((array)$category_child_child as $ccc) {
        			array_push($cate_ar, $ccc['category_id']);
        		}
        	}

        	$where_cate_ar = array();
        	foreach ((array)$cate_ar as $ca) {
        		array_push($where_cate_ar,' FIND_IN_SET(?, `category`) ');
        		array_push($where_param1, $ca);
        	}



            $where2 = "
				WHERE (".implode(" OR ", $where_cate_ar ).")
			";
        }

        if($get['area'] != null && $get['area'] != ''){
            $add = ($where2 == '')? " WHERE " : " AND ";
            $where2 .= $add. " FIND_IN_SET(?, `area`)
			";
            array_push($where_param1, $get['area']);
        }



        if($get['date'] != null && $get['date'] != ''){

        	$inner_join_where = " WHERE `exception_date` = ? ";

            $inner_join_col ='`tre`.`max_number_of_people`,';
            $where .= "
				AND ? BETWEEN `start_date` AND `end_date`
				AND (`tre`.`max_number_of_people` <> 0 || `tre`.`max_number_of_people` IS NULL) AND !FIND_IN_SET(?, `holiday_week`)
			";

            array_push($where_param2, $get['date']);
            array_push($where_param3, $get['date'], date("w", strtotime($get['date'])));
        }

        if($get['num'] != null && $get['num'] != ''){
        	$ijw_add = ($inner_join_where != null && $inner_join_where != '')? " AND ":" WHERE ";

        	$inner_join_where .= $ijw_add . " `max_number_of_people` >= ? ";

            $inner_join_col ='`tre`.`max_number_of_people`,';
            $where .= "
				AND `t_tour_relation`.`max_number_of_people` >= ?
			";

            array_push($where_param2, $get['num']);
            array_push($where_param3, $get['num']);
        }

        $where_array_m = array_merge($where_param1, $where_param2, $where_param3);

//         if($inner_join == null || $inner_join == ''){
            $inner_join .= "
							LEFT JOIN (
								SELECT `tour_relation_id`, `tour_relation_exception_id`, `max_number_of_people`
								FROM `t_tour_relation_exception`
								".$inner_join_where."
							) AS `tre` USING(`tour_relation_id`)
						";
//         }


        $tour_count = $this->common_logic->select_logic("
		SELECT
			`t`.`tour_id`
		FROM `t_tour_relation`
		INNER JOIN (
			SELECT `tour_id`, `store_basic_id`, `title`, `img`, `d_title`, `d_detail`, `public_flg`, `del_flg`, `update_at`
			FROM `t_tour`
			".$where2."
		) AS `t` USING(`tour_id`)
		INNER JOIN (SELECT `store_basic_id`, `company_name_eng` FROM `t_store_basic` WHERE `del_flg` = 0 AND `auth_flg` = 1 ) AS `sb` USING(`store_basic_id`)
		".$inner_join."
		WHERE
			`t`.`public_flg` = 0
			AND `t`.`del_flg` = 0
			".$where."
 		GROUP BY `tour_id`
		", $where_array_m);

        if($tour_count == null || $tour_count == '')$tour_count = array();
        $all_cnt = count($tour_count);

        //総ページ数
        $page_num = ceil($all_cnt / $disp_num);

        $limit = $disp_num;
        $offset = $now_page * $disp_num;
        array_push($where_array_m, $limit, $offset);

        $tour = $this->common_logic->select_logic("
		SELECT
			`t`.`tour_id`,
			`tour_relation_id`,
			`start_date`,
			`end_date`,
			".$inner_join_col."
			`t_tour_relation`.`max_number_of_people` AS `mup`,
			`title`,
			`company_name_eng`,
			`youtube`,
			`img`,
			`d_title`,
			`d_detail`,
			`store_basic_id`,
			`t`.`public_flg`,
			`t`.`del_flg`,
			`t`.`update_at`
		FROM `t_tour_relation`
		INNER JOIN (
			SELECT `tour_id`, `store_basic_id`, `title`, `img`,`youtube`, `d_title`, `d_detail`, `public_flg`, `del_flg`, `update_at`
			FROM `t_tour`
			".$where2."
		) AS `t` USING(`tour_id`)
		INNER JOIN (SELECT `store_basic_id`, `company_name_eng` FROM `t_store_basic` WHERE `del_flg` = 0 AND `auth_flg` = 1 ) AS `sb` USING(`store_basic_id`)
		".$inner_join."
		WHERE
			`t`.`public_flg` = 0
			AND `t`.`del_flg` = 0
			".$where."
		GROUP BY `tour_id`
		ORDER BY `update_at` DESC
		LIMIT ? OFFSET ?
		", $where_array_m);


        $tour_html = '';
        foreach ((array)$tour as $row) {

            $img_f =explode(",", $row["img"]);
            if($img_f[0] == null || $img_f[0] == ''){
            	$img = '<img src="../img/noimage.jpg" alt="noimage">';
            }else{
            	$img = '<img src="../upload_files/tour/'.$img_f[0].'" alt="">';
            }

            $yt_html = '';
            $style = 'style="flex: 0 0 48%; max-width: 48%; text-align: center; box-sizing: border-box;border-radius: 5px;"';

            if($row['youtube'] != null && $row['youtube'] != ''){
                $yts = htmlspecialchars_decode($row['youtube']);
                preg_match_all('/<iframe.*?<\/iframe>/is', $yts, $matches);
                $iframes = $matches[0];

                if (!empty($iframes)) {
                    for ($i=0; $i < 2; $i++) {
                        $updatedIframe = preg_replace('/\s*(width|height)="[^"]*"/i', '', $iframes[$i]);
                        $updatedIframe = preg_replace('/<iframe(.*?)>/i', '<iframe$1 ' . $style . '>', $updatedIframe);
                        $yt_html .= $updatedIframe;
                    }
                }
            }

            $detail = mb_strimwidth($row["d_detail"], 0, 200, "…", "UTF-8");

            $date_where = '';
            if($get['date'] != null && $get['date'] != '')$date_where = '&date=' . $get['date'];


            $tour_html .= '<div class="planBox1 mT40">
							<div class="searchResultBoxPlan">
								<h4 class="rankingStoreName">
									<a href="./plan.php?tid='.$row["tour_id"].'&sbid='.$row["store_basic_id"].'">'.$row["title"].'</a>
									<!--<span class="rankingNameArea">'.$row['company_name_eng'].'</span>-->
								</h4>
								<div class="searchResultBoxPlanImg">
									'.$img.'
									<div style="display: flex; margin-top: 20px; justify-content: space-between; flex-wrap: wrap;">
									'.$yt_html.'
                                    </div>
								</div>
								<div class="searchResultBoxPlanList">
									<h2 class="rankingCatch">
										'.$row["d_title"].'
									</h2>
									<p class="rankingTxt">
										'.$detail.'
									</p>
									<div class="rankingPlanBox">
										<a href="plan.php">
                                            '.$row["company_name_eng"].'
											<div class="rankingBtnBox">
												<a href="./plan.php?tid='.$row["tour_id"].'&sbid='.$row["store_basic_id"].$date_where.'" class="btnBase btnBg2 btnW1 btnH2">View the detail</a>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>';
        }

        if($tour_html == null || $tour_html == ''){
            $tour_html = '<p>Sorry. Not found.<p>';
        }





        $pager = '';
        if($all_cnt > 0){

        	$url_add = '';
        	if(strpos($_SERVER['REQUEST_URI'], '?') !== false){
        		$url_add_ar = explode('?', $_SERVER['REQUEST_URI']);
        		$de = urldecode($url_add_ar[1]);
        		$gp = explode('&', $de);
        		foreach ($gp as $k => $as){
        			if(strpos($as, 'now') !== false) array_splice($gp, $k, 1);
        		}
        		array_values($gp);
        		$url_add = implode('&', $gp);
        	}

        	$pager_start = 0;
        	if($now_page > 2){
        		$pager_start = $now_page - 2;
        		if($now_page + 2 >= $page_num){
        			$pager_start = $now_page - 4  + ($page_num - $now_page);
        		}
        	}
        	if($pager_start < 0){
        		$pager_start = 0;
        	}


        	//戻る処理
        	if($now_page != 0){
        		$prev_num = $now_page - 1;
        		$p = '?now='.$prev_num;
        		if($url_add != '') $p .= '&' .$url_add;

        		$pager .= '
					<li>
						<a href="'.$p.'" class="pager_num">＜</a>
					</li>
						';
        	}

        	$max_page = $all_cnt/$disp_num;
        	define('DISPLAY_PAGER_CNT', 5);
        	$cnt = 0;
        	for ($i = $pager_start; $i < $page_num; $i++) {
        		$cnt++;

        		if($cnt > DISPLAY_PAGER_CNT){
        			break;
        		}

        		$disp_i = $i + 1;

        		if ($disp_i == $max_page + 1) {
        			break;
        		}

        		//現在のページクラス付与用
        		$active = '';
        		$url = '?now='.$i;
        		if($url_add != '') $url .= '&' .$url_add;
        		if($i == $now_page){
        			$url = "javascript:void(0);";
        			$active = 'active';
        		}

        		//数字処理
        		$pager .= '
					<li>
						<a class="pager_num '.$active.'" href="'.$url.'">'.$disp_i.'</a>
					</li>
					';

        	}

        	//次へ処理
        	if($page_num != $now_page +1 ){
        		$next_page = $now_page + 1;
        		$p = '?now='.$next_page;
        		if($url_add != '') $p .= '&' .$url_add;
        		$pager .= '
					<li>
						<a href="'.$p.'" class="pager_num">＞</a>
					</li>
						';
        	}
        }




        return array(
        		"tour_html" => $tour_html,
        		"pager" => $pager,
        );

    }

    public function get_tour_detail($tour_id) {
        $tour = $this->jis_common_logic->get_tour($tour_id);

        $result= array();
        $result["tour_base"] = $tour['tour'];
        $result['payment_way'] = str_replace(array("0", "1", "2"), array("Cash on site", "Immediate credit card payment（VISA / Master）", "Credit card on site（".$result["tour_base"]['card_choice']."）"), $tour['tour']['payment_way'] );

        $price = $this->jis_common_logic->calc_discount($tour['tour']['adult_fee'], $tour['tour']['discount_rate_setting']);
	$ch_price = $this->change_rate($price);

        $result["rsv_html"] = array("","","");

        $img_ar = explode(',', $result["tour_base"]['img']);
        if($img_ar[0] == null || $img_ar[0] == ''){
        	$img = '<img src="../img/noimage.jpg" alt="noimage">';
        }else{
        	$img = '<img src="../upload_files/tour/'.$img_ar[0].'" alt="">';
        }

        $week = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

        $html_t = '<div class="planCalNP mB10 planCalNPBoxN">
						<p style="text-align:right;font-size: 0.8em;display:block;margin-bottom: 5px; margin-right: 10px;">Search Date</p>
						<div class="planCalBtn">
							<div id="date" class="calender">
								<input type="text" id="dateCal" class="hide" style="display: none;">
							</div>
						</div>
						<div class="planCalBox">
							<div class="planCalPrev" id="prev">
								<a href="javascript:void(0)"><i class="fa fa-caret-left fcBaceC mR10" aria-hidden="true"></i>Prev.</a>
							</div>
							<div class="planCalNext" id="next">
								<a href="javascript:void(0)">Next<i class="fa fa-caret-right fcBaceC mL10" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>

						<div class="calTopTable">
							<div class="planCalBox2">
								<div class="planCalDate calHeight">&nbsp;</div>
								<div class="planCalRemain2">
									<div class="planDetailImg">
										'.$img.'
									</div>
									<div class="planDetailClose">
										'.$result['tour_base']['title'].'<br>'.$ch_price.'
									</div>
								</div>
							</div>';
        $html_t2 = '<div class="calTopTable">
							<div class="planCalBox2">
								<div class="planCalDate calHeight">&nbsp;</div>
								<div class="planCalRemain2">
									<div class="planDetailImg">
										'.$img.'
									</div>
									<div class="planDetailClose">
										'.$result['tour_base']['title'].'<br>'.$ch_price.'
									</div>
								</div>
							</div>';

        foreach ((array)$tour['tour_relation'] as $n => $tr) {
            $exp = $this->jis_common_logic->tour_relation_ex_ar_conv($tour['tour_relation_exception'][$tr['tour_relation_id']]);

            $s = date('Y-m-d');//$tr['start_date'];
            $e = $tr['end_date'];
            $ss = $tr['start_date'];
            if( date('Y-m-d', strtotime($tr['end_date'])) < date('Y-m-d', strtotime(date('Y-m-d') . ' +2 month ')))$e = date('Y-m-d', strtotime(date('Y-m-d') . ' +2 month '));
            $c = 0;
            $html ='';
            do{
            	$c++;
                if($s <= date('Y-m-d')){
                    $s = date("Y-m-d", strtotime($s . " +1 day "));
                    continue;
                }
                $limit_num = $tr['max_number_of_people'];
                if($exp[$s]) $limit_num = $exp[$s]['max_number_of_people'];


                $bc= '';
                if($week[date("w", strtotime($s))]== 'Sun')$bc= 'sunday';
                if($week[date("w", strtotime($s))]== 'Sat')$bc= 'sutrday';

                if(date("Y-m-d", strtotime($s)) <= date("Y-m-d", strtotime($tr['end_date']))){
                	$tour_sum = $this->common_logic->select_logic("SELECT SUM(`men_num`) AS `sum1`, SUM(`women_num`) AS `sum2`, SUM(`children_num`) AS `sum3` FROM `t_reservation` WHERE `tour_relation_id` = ? AND `del_flg` = 0 AND `cancel_flg` = 0 AND DATE(`come_date`) = ?", array($tr['tour_relation_id'], $s));
                	$sum = (int)$tour_sum[0]['sum1'] + (int)$tour_sum[0]['sum2'] + (int)$tour_sum[0]['sum3'];
                	if($limit_num - $sum > 0){
                		$limit_str = '<a href="reserve.php?trid='.$tr['tour_relation_id'].'&date='.$s.'">'.($limit_num - $sum).'</a>';
                	}else{
                		$limit_str = '<a href="javascript:void(0);">×</a>';
                	}
                }

                if($limit_num <= 0) $limit_str = '<a href="javascript:void(0);">×</a>';
                if(strpos($tr['holiday_week'], date("w", strtotime($s))) !== false) $limit_str = '<a href="javascript:void(0);">×</a>';
                if(date("Y-m-d", strtotime($s)) > date("Y-m-d", strtotime($tr['end_date']))) $limit_str = '<a href="javascript:void(0);">×</a>';
                if(date("Y-m-d", strtotime($ss)) > date("Y-m-d", strtotime($s))) $limit_str = '<a href="javascript:void(0);">×</a>';

                $html .= '<div class="planCalBox1 two_w_cal f_date first"
							date="'.$s.'" style="">
							<div class="planCalDate '.$bc.'">
								'.date("m/d", strtotime($s)).'<br>('.$week[date("w", strtotime($s))].')
							</div>

							<div class="planCalRemain  ">
								'.$limit_str.'
								<div class="planDetailClose">
									'.date("H:i", strtotime($tr['start_time'])).'<br> ～<br> '.date("H:i", strtotime($tr['end_time'])).'<br>
								</div>
							</div>
						</div>';

                $s = date("Y-m-d", strtotime($s . " +1 day "));
            }while(date($s) <= date($e) && $c < 100);
            if($n == 0){
                $result["rsv_html"][$n] = $html_t . $html. '</div><br>';
            }else{
                $result["rsv_html"][$n] = $html_t2 . $html. '</div><br>';
            }

        }


        return $result;


    }

    public function get_reserve_list_for_top($tour_id = null){

    	$where = ' AND `cancel_flg` = 0 ';
    	$where_p = array($_SESSION['jis']['login_member']['store_basic_id']);
    	$limit = 'LIMIT 5';
    	$order = ' ORDER BY `create_at` DESC';
    	if($tour_id  != null && $tour_id  != ''){
    		$where = ' AND `tour_id` = ? ';
    		array_push($where_p,$tour_id);
    		$limit = '';
    		$order = 'ORDER BY  cast(`cancel_flg` as signed) ASC, ( CURDATE() > DATE_FORMAT(`come_date`, "%Y%m%d") ) ASC, `come_date` ASC';
    	}

        $rsv = $this->common_logic->select_logic("
				SELECT `reservation_id`, `tour_relation_id`, `tour_id`, `title`, `start_date`, `start_time`,`order_id`,`cancel_flg`,`payment_way`, (`men_num` + `women_num` + `children_num` ) AS `total_num`, `total_add_tax`, `come_date`, `create_at`, `m`.`name`, `m`.`tel`
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
				".$limit."
				 ", $where_p);


        $html = '';
        foreach ((array)$rsv as $row) {

        	$cancel = '';
        	$cancel_color = '';
        	$cancel_ty = '0';
        	$cancel_btn = '<button type="button" class="mypageStoreInfoEditBtn2 s2 cancel_rsv" rid="'.$row['reservation_id'].'">キャンセル</button>';
        	if($tour_id  != null && $tour_id  != ''){
        		if($row['cancel_flg'] == 1){
        			$cancel = '<br><span style="color: #ff9d9d;">*Cancelled</span>';
        			$cancel_color = 'style="background-color: #888;"';
		        	$cancel_ty = '1';
		        	$cancel_btn = '';
        		}
        	}
        	$past = 0;
        	if(date('Y-m-d') > date('Y-m-d', strtotime($row['come_date']))){
        		$past = 1;
        	}

        	$payment_way = '';
        	if(strpos($row['payment_way'], "1") !== false ){
        		$payment_way = '(現地現金払い)';
        	}elseif(strpos($row['payment_way'], "3") !== false ){
        		$payment_way  = '(現地クレジットカード払い)';
        	}elseif(strpos($row['payment_way'], "2") !== false ){
        		$payment_way = '(サイト内支払い)';
        	}


            $html .= '
				<div class="mypageReservBox " '.$cancel_color.' dt="'.date('Y-m-d', strtotime($row['come_date'])).'" canc="'.$cancel_ty.'" past="'.$past.'">
					<div class="mypageReservStoreRow">
						<div class="mypageReservDate">
							<span>'.date('Y-m-d', strtotime($row['come_date'])).'</span><br>
							<span>'.date('H:i', strtotime($row['come_date'])).'</span><br>
							<span>'.$row['total_num'].'名様ご予約</span>'.$cancel.'
						</div>
						<div class="mypageReservNameBox">
							<div class="mypageStoreInfoName">'.$row['title'].'</div>
							<p class="mypageReservAdd">
								<span>'.$row['name'].'様</span><br>
								<span>TEL：'.$row['tel'].'</span><br>
								<span>'.$row['order_id'].'</span><br>
								<span>予約日時：'.date('Y年m月d日 H:i', strtotime($row['create_at'])).'</span>
							</p>
						</div>
					</div>
					<div class="mypageStoreInfoBtmBox">
						<div class="mypageStoreInfoEditBtnBox">
							<button type="button" class="mypageStoreInfoEditBtn1 s2"><a href="./reserve.php?rid='.$row['reservation_id'].'">編集・確認</a></button>
							'.$cancel_btn.'
						</div>
						<div class="mypageStoreInfoPrice">'.number_format($row['total_add_tax']).'円'.$payment_way.'</div>

					</div>
				</div>
';
        }


        if ($html == '') {
            $html = '<p class="mypageTxt">
								まだ予約はありません
							</p>';
        }


        return $html;

    }


    public function get_reserve_list__opt($tour_id = null){

    	$where_p = array($_SESSION['jis']['login_member']['store_basic_id']);
		$where = ' AND `tour_id` = ? ';
    	array_push($where_p,$tour_id);
    	$order = 'ORDER BY  cast(`cancel_flg` as signed) ASC, ( CURDATE() > DATE_FORMAT(`come_date`, "%Y%m%d") ) ASC, `cancel_flg` ASC, `come_date` ASC';

    	$rsv = $this->common_logic->select_logic("
				SELECT `reservation_id`, `tour_relation_id`, `tour_id`, `title`, `start_date`, `start_time`,`cancel_flg`,`payment_way`, (`men_num` + `women_num` + `children_num` ) AS `total_num`, `total_add_tax`, `come_date`, `m`.`name`, `m`.`tel`
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
				GROUP BY `come_date`
				".$order."
				", $where_p);


    	$opt = '';
    	foreach ((array)$rsv as $row) {
    		$opt .= '<option value="'.date('Y-m-d', strtotime($row['come_date'])).'">'.date('Y年m月d日', strtotime($row['come_date'])).'分</option>';
    	}
    	return $opt;

    }

    public function get_area_list(){
        $area_base_data = $this->jis_common_logic->area_array();
        $html = '';
        foreach($area_base_data as $key => $val){
          $html .= '
            <div class="card px-2 py-2 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area='.$key.'"><img src="img/'.$val['img'].'" alt="'.$val['eng'].'" class="card_image lazy"></a>
                    </div>
                </div>
            </div>
';

        }
        return $html;
    }

    public function get_cate_list(){
        $cate_base_data = $this->jis_common_logic->category_array();
        $html = '';
        foreach($cate_base_data as $key => $val){
          $html .= '
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate='.$key.'"><img src="img/'.$val['img'].'" alt="'.$val['eng'].'" class="card_image lazy"></a>
					</div>
				</div>
			</div>

';

        }
        return $html;

    }

    public function get_area_child_html($type){
        $area_base_data = $this->jis_common_logic->area_array();
        $html = '';
        $cnt = count($area_base_data);
        for($i = 1; $i < $cnt; $i++){
          $row = $area_base_data[$i];
          if($type == 'tokyo' && $i > 15){
            continue;
          }
          if($type == 'greater' && $i < 17){
            continue;
          }
          $html .= '
<div class="p__panel-link">
	<div class="c__layout-table-btn"><div class="cmm__table-cell">
		<div class="c__btn-balancer">
			<div class="cmsi__panel-link">
				<a href="search/?area='.$i.'">
					<div class="topServiceImg">
						<img src="img/'.$row['img'].'" alt="'.$row['eng'].'">
					</div>
					<div class="topServiceTxtBox">
						<h3 class="topServiceTxt1">'.$row['eng'].'</h3>
					</div>
				</a>
			</div>
		</div>
';
$i++;
$row = $area_base_data[$i];
          $html .= '
		</div><div class="cmm__table-cell">
			<div class="c__btn-balancer">
				<div class="cmsi__panel-link">
					<a href="search/?area='.$i.'">
						<div class="topServiceImg">
							<img src="img/'.$row['img'].'" alt="'.$row['eng'].'">
						</div>
						<div class="topServiceTxtBox">
							<h3 class="topServiceTxt1">'.$row['eng'].'</h3>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

';

        }
        return $html;
    }
    public function get_change_code(){
      $cr_res = $this->common_logic->select_logic("select * from t_currency_code as c JOIN t_member as m ON c.disp_name = m.nationality where m.member_id = ? ", array($_SESSION['jis']['login_member']['member_id']))[0];
      return $cr_res;
    }

    public function chk_nationaliry(){
      $is_change = false;
      if(isset($_SESSION['jis']['login_member']['member_id'])){
	$is_change = ($_SESSION['jis']['login_member']['nationality'] != 'Japan' && $_SESSION['jis']['login_member']['nationality'] != 'Other') ? true : false;
      }
      return $is_change;
    }

    public function change_rate($price){
      $c_price = '';
      if($this->chk_nationaliry()){

        $cr_data = $this->get_change_code();

        $req_url = 'https://v6.exchangerate-api.com/v6/578b63e20c4741dde8074fdb/latest/JPY';
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {

          try {
            $response = json_decode($response_json, true);

            if('success' === $response['result']) {
              $base_price = $price;
              $rates = $response['conversion_rates'][$cr_data['currency_code']];
              $c_price = round(($base_price * $rates), 2);
            }

          }catch(Exception $e) {
          }
          $c_price = $cr_data['currency_format'].$c_price;

        }
      }else{
        $c_price = '￥'.number_format($price);
      }
      return $c_price;
    }



    public function get_index_html(){

        $area_base_data = $this->jis_common_logic->area_array();


        $review_rank = $this->get_review_rank_data(4);
        $rev_html = '';
        $cnt = 1;
        foreach ((array)$review_rank as $rr){
        	$sb = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($rr['store_basic_id']));
        	$row = $sb[0];
        	$img = explode(",", $row['img']);
        	if($img[0] == null || $img[0] == ''){
        		$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
        	}else{
        		$img_tag = '<img src="upload_files/store_basic/'.$img[0].'" alt="'.$row['company_name_eng'].'" class="card_image lazy">';
        	}

            $rev_html .= '
			<div class="card px-2 py-2 col-md-3 col-sm-6 col-xs-6">
                <a href="search/agency_detail.php?sbid='.$row["store_basic_id"].'">
	                <div class="card-wrapper flip-card">
	                    <div class="card-img">
		                    <div class="card-img">
		                        '.$img_tag.'
		                    </div>
		                    <div class="img-text mbr-text mbr-fonts-style align-left mbr-white display-4">
		                         <img src="img/no'.$cnt.'.png" alt="No'.$cnt.'">
		                    </div>
	                    </div>
	                    <div class="card-box">
	                        <h3 class="mbr-title mbr-fonts-style mbr-bold mbr-black display-5">
	                           	'.$row['company_name_eng'].'
	                        </h3>
	                        <p class="mbr-card-text mbr-fonts-style align-left display-7">
	                           '.mb_strimwidth($row['cd_deatil'], 0, 100, "…", "UTF-8").'
	                        </p>
	                    </div>
	                </div>
                </a>
            </div>';
            ++$cnt;
        }
        if($rev_html == null || $rev_html == ''){
            $rev_html = '<div class="card px-3 py-4 col-lg-12"><p style="color: #000;">No Data.</p></div>';
        }


        $new_arrival = $this->get_new_arrival_data(12, array(
        		"param" => array(
        				"order" => "rand"
        		)
        ));
        $arr_html = '';
        $cnt = 1;

        foreach ((array)$new_arrival as $na){
            $row = $this->get_tour_detail_data($na['tour_id']);
            $img = explode(",", $row['img']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">';
            }




            $area_ar = explode(",", $row['area']);
            $tag = '';
            foreach ($area_base_data as $abd_id => $abd) {
                foreach ($area_ar as $area_id) {
                    if($abd_id == $area_id )
                        $tag = '<p class="'.$abd['tag'].'">'.$abd['eng'].'</p>';
                }
            }
            $price = $this->jis_common_logic->calc_discount($row['adult_fee'], $row['discount_rate_setting']);
            $ch_price = $this->change_rate($price);
            $arr_html .= '<div>
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        '.$img_tag.'
                    </div>
                    <div class="card-box">
                    	'.$tag.'
                        <a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
                        <h3 class="mbr-title mbr-fonts-style mbr-bold mbr-black display-5">
                            '.$row['title'].'
                        </h3>
                        <p class="mbr-card-text mbr-fonts-style align-left display-7 border_dot">
                           '.mb_strimwidth($row['d_detail'], 0, 100, "…", "UTF-8").'
                        </p>
						<p class="mbr-card-price display-5 b">'.$ch_price.' / Person</p>
						</a>
                    </div>
                </div>
            </div>';
            ++$cnt;
        }
        if($arr_html == null || $arr_html == ''){
            $arr_html = '<div class="card px-3 py-4 col-lg-12"><p style="color: #000;">No Data.</p></div>';
        }


        $rsv_rank = $this->get_reservation_rank_data(4);
        $rsv_html = '';
        $cnt = 1;
        foreach ((array)$rsv_rank as $rsv_r){
            $row = $this->get_tour_detail_data($rsv_r['tour_id']);
            $img = explode(",", $row['img']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">';
            }

            $rsv_html .= '<div class="card px-2 py-2 col-md-3 col-sm-6 col-xs-6">
                <a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
	                <div class="card-wrapper flip-card">
	                    <div class="card-img">
		                    <div class="card-img">
								'.$img_tag.'
		                    </div>
		                    <div class="img-text mbr-text mbr-fonts-style align-left mbr-white display-4">
		                         <img src="img/no'.$cnt.'.png" alt="No'.$cnt.'">
		                    </div>
	                    </div>
	                    <div class="card-box">
	                        <h3 class="mbr-title mbr-fonts-style mbr-bold mbr-black display-5">
	                           	'.$row['title'].'
	                        </h3>
	                        <p class="mbr-card-text mbr-fonts-style align-left display-7">
	                            '.mb_strimwidth($row['d_detail'], 0, 100, "…", "UTF-8").'
	                        </p>
	                    </div>
	                </div>
                </a>
            </div>';
            ++$cnt;
        }
        if($rsv_html == null || $rsv_html == ''){
            $rsv_html = '<div class="card px-3 py-4 col-lg-12"><p style="color: #000;">No Data.</p></div>';
        }




        $category_array = $this->jis_common_logic->category_array();
        $category_html = array();
        foreach ($category_array as $category_id => $str) {
        	$cate_ar = array($category_id);
        	$category_child = $this->common_logic->select_logic("select `category_id` from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 ", array($category_id));
        	foreach ((array)$category_child as $cc) {
        		array_push($cate_ar, $cc['category_id']);
        		$category_child_child = $this->common_logic->select_logic("select `category_id` from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 ", array($cc['category_id']));
        		foreach ((array)$category_child_child as $ccc) {
        			array_push($cate_ar, $ccc['category_id']);
        		}
        	}
        	$rand_flg = false;
        	if($category_id == '2' || $category_id == '3' ){
        		$rand_flg = true;
        	}
        	$cate_tour_data = $this->get_cate_tour_data_ar($cate_ar, 4, $rand_flg);
            $category_html[$str['eng']] = '';
            $cnt = 1;

            foreach ((array)$cate_tour_data as $ctd){
                $row = $this->get_tour_detail_data($ctd['tour_id']);
                $img = explode(",", $row['img']);
                if($img[0] == null || $img[0] == ''){
                	$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
                }else{
                	$img_tag = '<img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">';
                }

                $area_ar = explode(",", $row['area']);
                $tag = '';
                foreach ($area_base_data as $abd_id => $abd) {
                    foreach ($area_ar as $area_id) {
                        if($abd_id == $area_id )
                            $tag = '<p class="'.$abd['tag'].'">'.$abd['eng'].'</p>';
                    }
                }


                $price = $this->jis_common_logic->calc_discount($row['adult_fee'], $row['discount_rate_setting']);
		$ch_price = $this->change_rate($price);
                $category_html[$str['eng']] .= ' <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        '.$img_tag.'
                    </div>
                    <div class="card-box">
                       	'.$tag.'
                       	<a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
                        <h3 class="mbr-title mbr-fonts-style mbr-bold mbr-black display-5">
                            '.$row['title'].'
                        </h3>
                        <p class="mbr-card-text mbr-fonts-style align-left display-7 border_dot">
                            '.mb_strimwidth($row['d_detail'], 0, 100, "…", "UTF-8").'
                        </p>
						<p class="mbr-card-price display-5 b">'.$ch_price.' / Person</p>
						</a>
                    </div>
                </div>
            </div>';
                ++$cnt;
            }
            if($category_html[$str['eng']] == null || $category_html[$str['eng']] == ''){
                $category_html[$str['eng']] = '<div class="card px-3 py-4 col-lg-12"><p style="color: #000;">No Data.</p></div>';
            }
        }



        return array(
            'rev_html' => $rev_html,
            'arr_html' => $arr_html,
            'rsv_html' => $rsv_html,
            'category_html' => $category_html
        );

    }


    public function get_category_html($get){
        $where = array();
        if($get['cate'] != null && $get['cate'] != ''){
            $where = array(
                "where" => " and FIND_IN_SET(?, category) ",
                "param" => array($get['cate'])
            );
            $cate_child = $this->jis_common_logic->get_cate_child($get['cate']);
        }else{
            $cate_child = $this->jis_common_logic->get_cate_child();
        }

        return array(
            "new_ar_html" => $this->get_category_html_helper($cate_child, $this->get_new_arrival_data(5, $where), false),
            "reccomend_html" => $this->get_category_html_helper($cate_child, $this->get_review_rank_data(5, $where), true, "store"),
            "reservation_rank_html" => $this->get_category_html_helper($cate_child, $this->get_reservation_rank_data(5, $where)),
        );

    }

    public function get_category_html_helper($cate_child, $new_ar_data, $lank_flg = true, $type = null){
        $new_ar_html = '';
        $lank = 1;
        foreach ((array)$new_ar_data as $nad) {

        	if($type == 'store'){
        		$rowsb = $this->common_logic->select_logic("SELECT * FROM `t_store_basic` WHERE `store_basic_id` = ? ", array($nad['store_basic_id']));
        		$row = $rowsb[0];


        		$img = explode(",", $row['img']);
        		if($img[0] == null || $img[0] == ''){
        			$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
        		}else{
        			$img_tag = '<img src="upload_files/store_basic/'.$img[0].'" alt="'.$row['title'].'"width="70px">';
        		}

        		if($lank_flg)$lank_html = '<div class="lunchDailyRankOther">'.$lank.'</div>';

        		$r_html = '';
        		if ($lank_html != '') {
        			$r_html = '
                                        <div class="lunchDailyRankBox">
											'.$lank_html.'
										</div>';
        		}


        		$new_ar_html .= '<div class="lunchDaily">
								<a href="search/agency_detail.php?sbid='.$row["store_basic_id"].'">
									<div class="lunchDailyImg">
										'.$img_tag.'
									</div>
									<div class="lunchDailyTxtBox">
										'.$r_html.'
										<div class="lunchDailyTxtRight">
											<h4 class="lunchDailyAera">
												'.mb_strimwidth($row['company_name_eng'], 0, 30, "…", "UTF-8").'
											</h4>
											<p class="lunchDailyName">
												'.mb_strimwidth($row['cd_title'], 0, 50, "…", "UTF-8").'
											</p>
										</div>
									</div>
								</a>
							</div>';

        	}else{
        		$row = $this->get_tour_detail_data($nad['tour_id']);

        		$img = explode(",", $row['img']);
        		if($img[0] == null || $img[0] == ''){
        			$img_tag = '<img src="./img/noimage.jpg" alt="noimage">';
        		}else{
        			$img_tag = '<img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'"width="70px">';
        		}
        		if($lank_flg)$lank_html = '<div class="lunchDailyRankOther">'.$lank.'</div>';

        		$cate_ar = explode(",", $row['category']);
        		$tag = '';

        		foreach ((array)$cate_ar as $ca) {
        			foreach ((array)$cate_child as $cn =>$cc) {
        				if($ca == $cc['category_id'] || $ca == $cc['dear_id'] )$tag = $cc['category_eng'];
        				if($cn ==='child' ){
        					foreach ((array)$cc as $ccc) {
        						if($ca == $ccc['category_id'] || $ca == $cc['dear_id'] )$tag = $ccc['category_eng'];
        					}
        				}
        			}
        		}

        		$r_html = '';
        		if ($lank_html != '') {
        			$r_html = '
                                        <div class="lunchDailyRankBox">
											'.$lank_html.'
										</div>';
        		}


        		$new_ar_html .= '<div class="lunchDaily">
								<a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
									<div class="lunchDailyImg">
										'.$img_tag.'
									</div>
									<div class="lunchDailyTxtBox">
										'.$r_html.'
										<div class="lunchDailyTxtRight">
											<h4 class="lunchDailyAera">
												'.$tag.'
											</h4>
											<p class="lunchDailyName">
												'.mb_strimwidth($row['title'], 0, 50, "…", "UTF-8").'
											</p>
										</div>
									</div>
								</a>
							</div>';

        	}

            $lank++;
        }
        if($new_ar_html == null || $new_ar_html == ''){
            $new_ar_html = "<p style='color:#000;'>No Data.</p>";
        }
        return $new_ar_html;
    }


    public function get_category_child_html($get){

        function html($ch, $c){
            $html = '<div class="cmm__table-cell">
							<div class="c__btn-balancer">
								<div class="cmsi__panel-link">
									<a href="category.php?cate='.$ch['category_id'].'">
										<div class="topServiceImg">
											<img src="upload_files/category/'.$ch['thumbnail'].'" alt="'.$ch['category_eng'].'">
										</div>
										<div class="topServiceTxtBox">
											<h3 class="topServiceTxt1">'.$ch['category_eng'].'</h3>
										</div>
									</a>
								</div>
							</div>
						</div>';

            return $html;

        }


        $re = '';
        $cate_child = $this->jis_common_logic->get_cate_child($get['cate']);
        $c = 0;
        foreach ((array)$cate_child as $f => $cc) {
            if($f === 'child'){continue;}
            if( $c % 2 == 0 ){
                $re .= '<div class="p__panel-link">
							<div class="c__layout-table-btn">';
            }
            $re .= html($cc, $c);
            if($c % 2 == 1){
                $re .= '</div>
						</div>';
            }
            $c++;
        }
        $html = '';
        if($re != null && $re != ''){
            $html = '<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Type</h2>
							</div>
						</div>
					</section>
					<section class="topBox">
						'.$re.'
					</section>';
        }

        return $html;
    }


    public function get_review_rank_data($limit, $where = array())
    {
        $whereP = array();
        if (isset($where['param'])) {
            foreach ($where['param'] as $adp) {
                array_push($whereP, $adp);
            }
        }
        array_push($whereP, $limit);
//		return $this->common_logic->select_logic("select `tour_id`, `rev_cnt` from t_tour INNER JOIN (select count(`review_id`) as `rev_cnt` , `tour_id` from t_review where del_flg = 0 and public_flg = 0 group by tour_id  ) as `rev` USING(`tour_id`) where del_flg = 0 and public_flg = 0 ".$where['where']." order by rev_cnt DESC limit ? ", $whereP);
        $wh = (isset($where['where'])) ? $where['where'] : '';
//        return $this->common_logic->select_logic("
//				SELECT
//					`store_basic_id`, `rev_cnt`
//				FROM
//					`t_store_basic`
//				INNER JOIN (
//					SELECT
//						count(`review_id`) as `rev_cnt` , `store_id`
//					FROM
//						t_review
//					WHERE
//						del_flg = 0
//						AND public_flg = 0
//					GROUP BY store_id
//				) AS `rev`  ON (`store_basic_id` = `store_id`)
//				INNER JOIN (
//					SELECT
//						`tour_id`,
//						`store_basic_id`
//					FROM `t_tour`
//					WHERE
//						`del_flg` = 0
//						" . $wh . "
//				) as `tu` USING(`store_basic_id`)
//				WHERE `del_flg` = 0
//				and `auth_flg` = 1
//				GROUP BY `store_basic_id`
//				ORDER BY rev_cnt DESC
//				LIMIT ? ", $whereP
//        );
        return $this->common_logic->select_logic("
				SELECT
					`store_basic_id`, `browse_num` as `rev_cnt`
				FROM
					`t_store_basic`
				INNER JOIN (
					SELECT
						`tour_id`,
						`store_basic_id`
					FROM `t_tour`
					WHERE
						`del_flg` = 0 AND `public_flg` = 0 
						" . $wh . "
				) as `tu` USING(`store_basic_id`)
				WHERE `del_flg` = 0
				and `auth_flg` = 1
				GROUP BY `store_basic_id`
				ORDER BY rev_cnt DESC
				LIMIT ? ", $whereP
        );
    }

    public function get_new_arrival_data($limit, $where = array()){
        $whereP = array();
        $order = ' order by create_at DESC ';
        if($where['param'] != null ){
        	foreach ($where['param'] as $k => $adp) {
        		if($adp == 'rand'){
        			$order = ' order by RAND() ';
        		}else{
        			array_push($whereP, $adp);
        		}
        	}
        }
        array_push($whereP, $limit);
		return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select distinct `tour_id` from t_tour_relation where del_flg = 0 and CURDATE() <= `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 ".$where['where']." ".$order." limit ? ", $whereP);
    }

    public function get_reservation_rank_data($limit, $where = array()){
        $whereP = array();
        if($where['param'] != null ){
            foreach ($where['param'] as $adp) {array_push($whereP, $adp);}
        }
        $wh = (isset($where['where'])) ? $where['where'] : '';
        array_push($whereP, $limit);
// 		return $this->common_logic->select_logic("select `tour_id`, `rsv_num` from t_tour INNER JOIN (select `tour_id`, `rsv_num` from t_tour_relation INNER JOIN ( select count(reservation_id) as rsv_num, tour_relation_id from t_reservation where cancel_flg = 0 and del_flg = 0 ) as`rsv` USING(tour_relation_id) where del_flg = 0 and public_flg = 0 and CURDATE() between `start_date` and `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 ".$where['where']." order by rsv_num DESC limit ? ", $whereP);
//		return $this->common_logic->select_logic("select `tour_id`, `rsv_num` from t_tour INNER JOIN (select distinct `tour_id`, `rsv_num` from t_tour_relation INNER JOIN ( select count(reservation_id) as rsv_num, tour_relation_id from t_reservation where cancel_flg = 0 and del_flg = 0 group by tour_relation_id ) as`rsv` USING(tour_relation_id) where del_flg = 0 and CURDATE() <= `end_date`) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 ".$where['where']." order by rsv_num DESC limit ? ", $whereP);
        return $this->common_logic->select_logic("
				SELECT
					`store_basic_id`, `reserve_num` as `rsv_num`, `store_basic_id` as `sbid`, `tour_id`
				FROM
					`t_store_basic`
				INNER JOIN (
					SELECT
						`tour_id`,
						`store_basic_id`
					FROM `t_tour`
					WHERE
						`del_flg` = 0 AND `public_flg` = 0
						" . $wh . "
				) as `tu` USING(`store_basic_id`)
				WHERE `del_flg` = 0
				and `auth_flg` = 1
				GROUP BY `store_basic_id`
				ORDER BY rsv_num DESC
				LIMIT ? ", $whereP
        );
    }

    public function get_cate_tour_data($category_id, $limit){
// 		return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select `tour_id` from t_tour_relation where del_flg = 0 and public_flg = 0 and CURDATE() between `start_date` and `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 and find_in_set(?, `category`) order by create_at DESC limit ? ", array($category_id, $limit));
		return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select distinct `tour_id` from t_tour_relation where del_flg = 0 and CURDATE() <= `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 and find_in_set(?, `category`) order by create_at DESC limit ? ", array($category_id, $limit));
    }
    public function get_cate_tour_data_ar($category_id_ar, $limit, $rand = null){
    	$where_cate_ar = array();
    	$where_param = array();
    	foreach ($category_id_ar as $ca) {
    		array_push($where_cate_ar,' FIND_IN_SET(?, `category`) ');
    		array_push($where_param, $ca);
    	}
    	array_push($where_param, $limit);

    	$order = ' order by create_at DESC ';
    	if($rand == true){
    		$order = ' order by rand() ';
    	}

    	return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select distinct `tour_id` from t_tour_relation where del_flg = 0 and CURDATE() <= `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0  AND ( ".implode(" OR ", $where_cate_ar)." ) ".$order."  limit ? ", $where_param);
    }

    public function get_tour_detail_data($tour_id){
        $t_data = $this->common_logic->select_logic("select * from t_tour  where tour_id  = ? limit 1 ", array($tour_id));
        return $t_data[0];
    }


    public function get_tour_from_store($store_basic_id){
        $t_data = $this->common_logic->select_logic("select * from t_tour where store_basic_id = ? and public_flg = 0 and del_flg = 0", array($store_basic_id));

        $html = '';
        foreach ((array)$t_data as $t_data => $row){

            $img = explode(",", $row['img']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img  class="rankingBoxInImg" src="../upload_files/tour/'.$img[0].'" alt="'.$row['title'].'">';
            }

            $html .= '<div class="rankingBoxWrap">
						<div class="rankingBox">
							<div class="rankingBoxIn">
								<div class="rankingBoxInImgBox">
									'.$img_tag.'
								</div>
								<div class="rankingBoxInTxtBox">
									<div class="rankingBoxInTxtBoxTtlArea">
										<h3 class="rankingBoxInTxtBoxTtl">'.$row['title'].'</h3>
									</div>
									<div class="rankingBoxInTxtBoxTxtArea">
										<p class="rankingBoxInTxtBoxTxt">'.$row['d_detail'].'</p>
									</div>
									<div class="rankingBoxInTxtBoxBtnArea">
										<a href="plan.php?tid='.$row['tour_id'].'&sbid='.$row['store_basic_id'].'">
											<button type="button" class="btnBase btnBg2 btnW2 btnH1 ">View the list</button>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>';
        }
        return $html;

    }









    public function get_my_reserv(){

        function html($fr, $tour){
            $img = explode(",", $tour['img']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img alt="" src="../upload_files/tour/'.$img[0].'" class="mypageListBoxImg">';
            }

            $btn = '<a href="./booking_details.php?rid='.$fr['reservation_id'].'" class="btnBase btnBg1 btnW1 mypageListBoxJBtn">
							<span class="btnLh2">View the details</span>
						</a>';
            if($fr['cancel_flg'] == 1){
            	$btn = '<a href="javascript:void(0);" class="canceled">*Cancelled</a>';
            }

            $num = $fr['men_num']+$fr['women_num']+$fr['children_num'];
            $f_html = '<div class="mypageListBoxJ">
								<div class="mypageListBoxJCont">
									<div class="mypageListBoxJCapArea">
										<p class="mypageListBoxCap">'.date("d/M/Y", strtotime($fr['come_date'])).' <br class="hidden-xs">'.date("H:i", strtotime($fr['come_date'])).'</p>
										<p class="mypageListBoxCap">reservation <br class="hidden-xs">for '.$num.'</p>
									</div>
									<div class="mypageListBoxJImgArea">
										'.$img_tag.'
									</div>
									<div class="mypageListBoxJTtlArea">
										<h4 class="mypageListBoxJTtl">'.$tour['title'].'</h4>
									</div>
								</div>
								<div class="mypageListBoxJBtnArea mt-n">
									'.$btn.'
								</div>
							</div>';

            return $f_html;
        }


        $member_id = $_SESSION['jis']['login_member']['member_id'];
        $now_date = date('Y-m-d H:i:s');

        $f_rvs = $this->common_logic->select_logic("select * from t_reservation where  member_id = ? and come_date >= ?  order by cancel_flg asc, come_date asc", array($member_id, $now_date));

        $f_html = '';
        foreach ((array)$f_rvs as $fr){
            $tour = $this->jis_common_logic->get_tour($fr['tour_relation_id'], true);
            $f_html .= html($fr,$tour['tour']);
        }
        if($f_html == '' || $f_html == null){
            $f_html = '
			<p class="mypageTxt">
				Not registered yet
			</p>';
        }

        $p_rvs = $this->common_logic->select_logic("select * from t_reservation where  member_id = ? and come_date < ? and cancel_flg = 0 order by come_date asc", array($member_id, $now_date));

        $p_html = '';
        foreach ((array)$p_rvs as $pr){

            $tour = $this->jis_common_logic->get_tour($pr['tour_relation_id'], true);
            $p_html .= html($pr,$tour['tour']);
        }
        if($p_html == '' || $p_html == null){
            $p_html = '
			<p class="mypageTxt">
				Not registered yet
			</p>';
        }





        return array(
            "f_html" => $f_html,
            "p_html" => $p_html,
        );

    }

    public function get_my_favorite(){

    	$member_id = $_SESSION['jis']['login_member']['member_id'];

    	$f_rvs = $this->common_logic->select_logic("select * from t_member_favorite where  member_id = ? order by create_at desc", array($member_id));

    	$html = '';
    	foreach ((array)$f_rvs as $fr){
    		$tour = $this->jis_common_logic->get_tour($fr['tour_id']);
    		$img = explode(",", $tour['tour']['img']);
    		if($img[0] == null || $img[0] == ''){
    			$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
    		}else{
    			$img_tag = '<img alt="" src="../upload_files/tour/'.$img[0].'" class="mypageListBoxImg">';
    		}
    		$html .= '
							<div class="mypageListBoxJ favWrap">
								<div class="mypageListBoxJCont">
									<div class="mypageListBoxJImgArea">
										'.$img_tag.'
									</div>
									<div class="mypageListBoxJTtlArea">
										<h4 class="mypageListBoxJTtl">'.$tour['tour']['title'].'</h4>
										<div class="mypageStoreInfoEditBtnBox">
											<button type="button" class="mypageStoreInfoEditBtn1 lg"><a href="../search/plan.php?tid='.$fr['tour_id'].'&sbid='.$fr['store_basic_id'].'">View the details</a></button>
											<button type="button" class="mypageStoreInfoEditBtn2  delete_fav" fav="'.$fr['member_favorite_id'].'">delete</button>
										</div>
									</div>
								</div>
							</div>';
    	}
    	if($html == '' || $html == null){
    		$html = '
			<p class="mypageTxt">
				Not registered yet
			</p>';
    	}


    	return $html;

    }



    public function create_recent_view($path){
        $html = '';
        $c = 0;
        foreach ((array)$_SESSION['jis']['recent'] as $tour_id){
            $tour = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($tour_id));
            $row = $tour[0];
            $cate_ar = explode(",", $row['category']);
            $cate_child = $this->jis_common_logic->get_cate_child($row['cate']);
            $tag = '';
            foreach ((array)$cate_ar as $ca) {
                foreach ((array)$cate_child as $cn =>$cc) {
                    if($ca == $cc['category_id'] )$tag = $cc['category_eng'];
                    if($cn ==='child' ){
                        foreach ((array)$cc as $ccc) {
                            if($ca == $ccc['category_id'] )$tag = $ccc['category_eng'];
                        }
                    }
                }
            }

            $url = $path.'search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"];
            $img = explode(",", $row['img']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="'.$path.'img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img src="'.$path.'upload_files/tour/'.$img[0].'" alt="'.$row['title'].'">';
            }

            $html .='<a href="'.$url.'" class="recentBox">
						<div class="recentBoxImg">
							'.$img_tag.'
						</div>
						<div class="recentBoxAr">
							<p>'.$row['title'].'</p>
							<p>'.$tag.'</p>
						</div>
					</a>';

            ++$c;

            if($c > 4){
                break;
            }

        }

        return $html;

    }


    public function get_review_list_for_front($store_basic_id){
        $rev = $this->common_logic->select_logic("select * from t_review where store_id = ? and del_flg = 0  and public_flg = 0 ", array($store_basic_id));
        foreach ((array)$rev as $row){

            $star = str_repeat("★", $row['review_point']) . str_repeat("☆", 5 -$row['review_point']);
            $tour  = $this->common_logic->select_logic("select * from t_member where member_id = ? ", array($row['member_id']));
            $t  = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($row['tour_id']));
            $img = explode(",", $tour[0]['icon']);
            if($img[0] == null || $img[0] == ''){
            	$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
            }else{
            	$img_tag = '<img class="rankingBoxInImg" src="../upload_files/member/'.$img[0].'" alt="'.$tour[0]['title'].'">';
            }

            $reply='';
            if($row['reply'] != null && $row['reply']!= ''){
            	$reply='
									<div style="border:1px solid #DDD;padding: 10px;margin-top:10px;">
										<p style="font-weight:bold;">Reply</p>
										<p>'.$row['reply'].'</p>
									</div>';
            }


            $html .= '
            			<div class="revArea">
								<div class="revIm">
									'.$img_tag.'
								</div>
								<div class="revTxt">
									<h4 class="reviewAreaTtl">'.$row['create_at'].'</h4>
									<time class="reviewAreaTime">'.date('Y.m.d', strtotime($row['create_at'])).'</time>
									<div class="reviewStar">
										<p>'.$row['nicname'].'</p>
										<p'.$star.'</p>
									</div>
									<p class="reviewStrDetail">'.nl2br($row['comment']).'</p>
									'.$reply.'
								</div>
							</div>';

        }
        if($html == '' || $html == null){
        	$html = 'No review.';
        }

        return $html;
    }

    public function get_review_list_for_qg($store_basic_id){
    	$rev = $this->common_logic->select_logic("select * from t_review where store_id = ? and del_flg = 0  and public_flg = 0 ", array($store_basic_id));
    	foreach ((array)$rev as $row){

    		$star = str_repeat("★", $row['review_point']) . str_repeat("☆", 5 -$row['review_point']);
    		$tour  = $this->common_logic->select_logic("select * from t_member where member_id = ? ", array($row['member_id']));
    		$t  = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($row['tour_id']));
    		$img = explode(",", $tour[0]['icon']);
    		if($img[0] == null || $img[0] == ''){
    			$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
    		}else{
    			$img_tag = '<img class="rankingBoxInImg" src="../upload_files/member/'.$img[0].'" alt="'.$tour[0]['title'].'">';
    		}


    		$html .= '
            		<div class="mypageReservBox " dt="2019-11-28">
						<div class="mypageReservStoreRow">
							<div class="mypageReservDate">
								'.$img_tag.'
							</div>
							<div class="mypageReservNameBox">
								<div class="mypageStoreInfoName">'.$t[0]['title'].'</div>
								<p class="mypageReservAdd">
									<span>'.$row['nicname'].'</span><br>
									<span>'.$star.'</span><br>
									<span>'.$row['comment'].'</span>
								</p>
							</div>
						</div>
						<div class="mypageStoreInfoBtmBox">
							<div class="mypageStoreInfoEditBtnBox">
								<button type="button" class="mypageStoreInfoEditBtn1 s2"><a href="./review_reply.php?revid='.$row['review_id'].'">編集・確認</a></button>
							</div>
						</div>
					</div>';

    	}
    	if($html == '' || $html == null){
    		$html = 'No review.';
    	}

    	return $html;
    }

    public function get_blling_date($store_basic_id){
	$st_res = $this->common_logic->select_logic("SELECT create_at FROM t_store_basic WHERE store_basic_id = ?", array($store_basic_id))[0];
	$date_m = date("Y-m", strtotime($st_res['create_at']));
        $prev_month = date('Y-m-d', strtotime('-1 month'));
	$startYear = date("Y", strtotime($st_res['create_at']));;
	$startMonth = date("m", strtotime($st_res['create_at']));;

	$now = new DateTime('first day of last month');

	$startDate = new DateTime("$startYear-$startMonth-01");

	$interval = $startDate->diff($now);
	$m_cnt = $interval->y * 12 + $interval->m;
	$option = '<option value="">選択してください</option>';
	for($i = 0; $i < $m_cnt; $i++){
		$target = date("Y年m月", strtotime($prev_month . "-".$i. " month"));
		$option .= '<option value="'.$target.'">'.$target.'</option>';
        }
	return $option;
    }


}
?>