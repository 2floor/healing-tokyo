<?php
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
        foreach ($tour as $row) {


            $public_str = '<span class="mypageStoreRelease now">公開中</span>';
            $public_ct = '<button type="button" class="mypageStoreInfoEditBtn2 public_tour" t="1" tid="'.$row['tour_id'].'">非公開</button>';
            if($row['public_flg'] == 1){
                $public_str = '<span class="mypageStoreRelease">非公開</span>';
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
						</div>
						<div class="mypageStoreInfoPrice">'.number_format($row['adult_fee']).'円</div>

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

        if ($get['date'] != '' && $get['date'] != null) {
            $date_array = explode("/", "", $get['date']);
            $get['date'] = $date_array[2].$date_array[0].$date_array[1];
        }

        $where ='';
        $where2 ='';
        $inner_join ='';
        $inner_join_col ='';
        $where_param = array();

        if($get['cate'] != null && $get['cate'] != ''){
            $where2 = "
				WHERE FIND_IN_SET(?, `category`)
			";
            array_push($where_param, $get['cate']);
        }

        if($get['area'] != null && $get['area'] != ''){
            $add = ($where2 == '')? " WHERE " : " AND ";
            $where2 .= $add. " FIND_IN_SET(?, `area`)
			";
            array_push($where_param, $get['area']);
        }



        if($get['date'] != null && $get['date'] != ''){

            $inner_join = "
							LEFT JOIN (
								SELECT `tour_relation_id`, `tour_relation_exception_id`, `max_number_of_people`
								FROM `t_tour_relation_exception`
								WHERE `exception_date` = ?
							) AS `tre` USING(`tour_relation_id`)
						";

            $inner_join_col ='`tre`.`max_number_of_people`,';
            $where = "
				AND ? BETWEEN `start_date` AND `end_date`
				AND (`tre`.`max_number_of_people` <> 0 || `tre`.`max_number_of_people` IS NULL)
			";

            array_push($where_param, $get['date'], $get['date']);
        }

        if($get['num'] != null && $get['num'] != ''){

            $inner_join .= "
							LEFT JOIN (
								SELECT `tour_relation_id`, `tour_relation_exception_id`, `max_number_of_people`
								FROM `t_tour_relation_exception`
								WHERE `max_number_of_people` < ?
							) AS `tre` USING(`tour_relation_id`)
						";

            $inner_join_col ='`tre`.`max_number_of_people`,';
            $where = "
				AND (`tre`.`max_number_of_people` <> 0 || `tre`.`max_number_of_people` IS NULL)
			";

            array_push($where_param, $get['num']);
        }

        if($inner_join == null || $inner_join == ''){
            $inner_join = "
							LEFT JOIN (
								SELECT `tour_relation_id`, `tour_relation_exception_id`, `max_number_of_people`
								FROM `t_tour_relation_exception`
							) AS `tre` USING(`tour_relation_id`)
						";
        }


        $tour = $this->common_logic->select_logic("
		SELECT
			`t`.`tour_id`,
			`tour_relation_id`,
			`start_date`,
			`end_date`,
			".$inner_join_col."
			`title`,
			`company_name_eng`,
			`img`,
			`d_title`,
			`d_detail`,
			`store_basic_id`,
			`t`.`public_flg`,
			`t`.`update_at`
		FROM `t_tour_relation`
		INNER JOIN (
			SELECT `tour_id`, `store_basic_id`, `title`, `img`, `d_title`, `d_detail`, `public_flg`, `update_at`
			FROM `t_tour`
			".$where2."
		) AS `t` USING(`tour_id`)
		INNER JOIN (SELECT `store_basic_id`, `company_name_eng` FROM `t_store_basic` WHERE `del_flg` = 0 AND `auth_flg` = 1 ) AS `sb` USING(`store_basic_id`)
		".$inner_join."
		WHERE
			`t`.`public_flg` = 0
			".$where."
		GROUP BY `tour_id`
		ORDER BY `update_at` DESC
		", $where_param);


        $tour_html = '';
        foreach ((array)$tour as $row) {

            $img_f =explode(",", $row["img"]);
            $img = '<img src="../upload_files/tour/'.$img_f[0].'" alt="">';

            $tour_html .= '<div class="planBox1 mT40">
							<div class="searchResultBoxPlan">
								<h4 class="rankingStoreName">
									<a href="./plan.php?tid='.$row["tour_id"].'&sbid='.$row["store_basic_id"].'">'.$row["title"].'</a>
									<span class="rankingNameArea">'.$row['company_name_eng'].'</span>
								</h4>
								<div class="searchResultBoxPlanImg">
									'.$img.'
								</div>
								<div class="searchResultBoxPlanList">
									<h2 class="rankingCatch">
										'.$row["d_title"].'
									</h2>
									<p class="rankingTxt">
										'.$row["d_detail"].'
									</p>
									<div class="rankingPlanBox">
										<a href="plan.php">
											<div class="rankingBtnBox">
												<a href="./plan.php?tid='.$row["tour_id"].'&sbid='.$row["store_basic_id"].'" class="btnBase btnBg2 btnW1 btnH2">View the detail</a>
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

        return $tour_html;

    }

    public function get_tour_detail($tour_id) {
        $tour = $this->jis_common_logic->get_tour($tour_id);

        $result= array();
        $result["tour_base"] = $tour['tour'];
        $result['payment_way'] = str_replace(array("0", "1"), array("Local payment", "credit payment"), $tour['tour']['payment_way'] );


        $result["rsv_html"] = array("","","");

        $img_ar = explode(',', $result["tour_base"]['img']);

        $week = array("日","月","火","水","木","金","土");

        $html_t = '<div class="planCalNP mB10 planCalNPBoxN">
						<div class="planCalBtn">
							<div id="date" class="calender">
								<input type="text" id="dateCal" class="hide" style="display: none;">
							</div>
						</div>
						<div class="planCalBox">
							<div class="planCalPrev" id="prev">
								<a href="javascript:void(0)"><i class="fa fa-caret-left fcBaceC mR10" aria-hidden="true"></i>PRE</a>
							</div>
							<div class="planCalNext" id="next">
								<a href="javascript:void(0)">NEXT<i class="fa fa-caret-right fcBaceC mL10" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>

						<div class="calTopTable">
							<div class="planCalBox2">
								<div class="planCalDate calHeight">&nbsp;</div>
								<div class="planCalRemain2">
									<div class="planDetailImg">
										<img src="../upload_files/tour/'.$img_ar[0].'" alt="">
									</div>
									<div class="planDetailClose">
										'.$result['tour_base']['title'].'<br>￥'.number_format($result['tour_base']['adult_fee']).'
									</div>
								</div>
							</div>';
        $html_t2 = '<div class="calTopTable">
							<div class="planCalBox2">
								<div class="planCalDate calHeight">&nbsp;</div>
								<div class="planCalRemain2">
									<div class="planDetailImg">
										<img src="../upload_files/tour/'.$img_ar[0].'" alt="">
									</div>
									<div class="planDetailClose">
										'.$result['tour_base']['title'].'<br>￥'.number_format($result['tour_base']['adult_fee']).'
									</div>
								</div>
							</div>';

        foreach ($tour['tour_relation'] as $n => $tr) {

            $exp = $this->jis_common_logic->tour_relation_ex_ar_conv($tour['tour_relation_exception'][$tr['tour_relation_id']]);

            $s = $tr['start_date'];
            $e = $tr['end_date'];
            $html ='';
            do{
                if($s <= date('Y-m-d')){
                    $s = date("Y-m-d", strtotime($s . " +1 day "));
                    continue;
                }
                $limit_num = $tr['max_number_of_people'];
                if($exp[$s]) $limit_num = $exp[$s]['max_number_of_people'];

                $bc= '';
                if($week[date("w", strtotime($s))]== '日')$bc= 'sunday';
                if($week[date("w", strtotime($s))]== '土')$bc= 'sutrday';

                $limit_str = '<a href="reserve.php?trid='.$tr['tour_relation_id'].'&date='.$s.'">'.$limit_num.'</a>';
                if($limit_num <= 0) $limit_str = '<a href="javascript:void(0);">×</a>';

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
            }while(date($s) <= date($e));
            if($n == 0){
                $result["rsv_html"][$n] = $html_t . $html. '</div><br>';
            }else{
                $result["rsv_html"][$n] = $html_t2 . $html. '</div><br>';
            }

        }


        return $result;


    }

    public function get_reserve_list_for_top(){


        $rsv = $this->common_logic->select_logic("
				SELECT `tour_relation_id`, `tour_id`, `title`, `start_date`, `start_time`, (`men_num` + `women_num` + `children_num` ) AS `total_num`, `come_date`, `m`.`name`, `m`.`tel`
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
						AND `cancel_flg` = 0
				ORDER BY `create_at` DESC
				LIMIT 5 ", array($_SESSION['jis']['login_member']['store_basic_id']));


        $html = '';
        foreach ($rsv as $row) {
            $html .= '
				<div class="mypageReservBox">
						<div class="mypageReservStoreRow">
							<div class="mypageReservDate">
								<span>'.date('Y-m-d', strtotime($row['come_date'])).'</span><br>
								<span>'.date('H:i', strtotime($row['start_time'])).'</span><br>
								<span>'.$row['total_num'].'名様ご予約</span>
							</div>
							<div class="mypageReservNameBox">
								<div class="mypageStoreInfoName">'.$row['title'].'</div>
								<p class="mypageReservAdd">
									<span>'.$row['name'].'様</span><br>
									<span>TEL：'.$row['tel'].'</span>
								</p>
							</div>
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

    public function get_index_html(){

        $area_base_data = $this->jis_common_logic->area_array();


        $review_rank = $this->get_review_rank_data(4);
        $rev_html = '';
        $cnt = 1;
        foreach ((array)$review_rank as $rr){
            $row = $this->get_tour_detail_data($rr['tour_id']);
            $img = explode(",", $row['img']);

            $rev_html .= '<div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
	                <div class="card-wrapper flip-card">
	                    <div class="card-img">
		                    <div class="card-img">
		                        <img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">
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
        if($rev_html == null || $rev_html == ''){
            $rev_html = '<div class="card px-3 py-4 col-lg-12"><p style="color: #000;">No Data.</p></div>';
        }


        $new_arrival = $this->get_new_arrival_data(12);
        $arr_html = '';
        $cnt = 1;

        foreach ((array)$new_arrival as $na){
            $row = $this->get_tour_detail_data($na['tour_id']);
            $img = explode(",", $row['img']);

            $area_ar = explode(",", $row['area']);
            $tag = '';
            foreach ($area_base_data as $abd_id => $abd) {
                foreach ($area_ar as $area_id) {
                    if($abd_id == $area_id )
                        $tag = '<p class="'.$abd['tag'].'">'.$abd['eng'].'</p>';
                }
            }

            $arr_html .= '<div>
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">
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
						<p class="mbr-card-price display-5 b">￥'.number_format($row['adult_fee']).' / Day</p>
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

            $rsv_html .= '<div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <a href="search/plan.php?tid='.$row['tour_id'].'&sbid='.$row["store_basic_id"].'">
	                <div class="card-wrapper flip-card">
	                    <div class="card-img">
		                    <div class="card-img">
		                        <img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">
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
            $cate_tour_data = $this->get_cate_tour_data($category_id, 4);
            $category_html[$str['eng']] = '';
            $cnt = 1;

            foreach ((array)$cate_tour_data as $ctd){
                $row = $this->get_tour_detail_data($ctd['tour_id']);
                $img = explode(",", $row['img']);

                $area_ar = explode(",", $row['area']);
                $tag = '';
                foreach ($area_base_data as $abd_id => $abd) {
                    foreach ($area_ar as $area_id) {
                        if($abd_id == $area_id )
                            $tag = '<p class="'.$abd['tag'].'">'.$abd['eng'].'</p>';
                    }
                }

                $category_html[$str['eng']] .= ' <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'" class="card_image lazy">
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
						<p class="mbr-card-price display-5 b">￥'.number_format($row['adult_fee']).' / Day</p>
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
            "reccomend_html" => $this->get_category_html_helper($cate_child, $this->get_review_rank_data(5, $where)),
            "reservation_rank_html" => $this->get_category_html_helper($cate_child, $this->get_reservation_rank_data(5, $where)),
        );

    }

    public function get_category_html_helper($cate_child, $new_ar_data, $lank_flg = true){
        $new_ar_html = '';
        $lank = 1;
        foreach ((array)$new_ar_data as $nad) {

            $row = $this->get_tour_detail_data($nad['tour_id']);
            $img = explode(",", $row['img']);
            if($lank_flg)$lank_html = '<div class="lunchDailyRankOther">'.$lank.'</div>';

            $cate_ar = explode(",", $row['category']);
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
										<img src="upload_files/tour/'.$img[0].'" alt="'.$row['title'].'"width="70px">
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


    public function get_review_rank_data($limit,$where = array()){
        $whereP = array();
        if($where['param'] != null ){
            foreach ($where['param'] as $adp) {array_push($whereP, $adp);}
        }
        array_push($whereP, $limit);
        return $this->common_logic->select_logic("select `tour_id`, `rev_cnt` from t_tour INNER JOIN (select count(`review_id`) as `rev_cnt` , `tour_id` from t_review where del_flg = 0 and public_flg = 0 group by tour_id  ) as `rev` USING(`tour_id`) where del_flg = 0 and public_flg = 0 ".$where['where']." order by rev_cnt DESC limit ? ", $whereP);
    }

    public function get_new_arrival_data($limit, $where = array()){
        $whereP = array();
        if($where['param'] != null ){
            foreach ($where['param'] as $adp) {array_push($whereP, $adp);}
        }
        array_push($whereP, $limit);
        return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select `tour_id` from t_tour_relation where del_flg = 0 and public_flg = 0 and CURDATE() between `start_date` and `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 ".$where['where']." order by create_at DESC limit ? ", $whereP);
    }

    public function get_reservation_rank_data($limit, $where = array()){
        $whereP = array();
        if($where['param'] != null ){
            foreach ($where['param'] as $adp) {array_push($whereP, $adp);}
        }
        array_push($whereP, $limit);
        return $this->common_logic->select_logic("select `tour_id`, `rsv_num` from t_tour INNER JOIN (select `tour_id`, `rsv_num` from t_tour_relation INNER JOIN ( select count(reservation_id) as rsv_num, tour_relation_id from t_reservation where cancel_flg = 0 and del_flg = 0 ) as`rsv` USING(tour_relation_id) where del_flg = 0 and public_flg = 0 and CURDATE() between `start_date` and `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 ".$where['where']." order by rsv_num DESC limit ? ", $whereP);

    }

    public function get_cate_tour_data($category_id, $limit){
        return $this->common_logic->select_logic("select `tour_id`, `create_at` from t_tour INNER JOIN (select `tour_id` from t_tour_relation where del_flg = 0 and public_flg = 0 and CURDATE() between `start_date` and `end_date` ) as`rel` USING(tour_id)  where del_flg = 0 and public_flg = 0 and find_in_set(?, `category`) order by create_at DESC limit ? ", array($category_id, $limit));
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

            $html .= '<div class="rankingBoxWrap">
						<div class="rankingBox">
							<div class="rankingBoxIn">
								<div class="rankingBoxInImgBox">
									<img  class="rankingBoxInImg" src="../upload_files/tour/'.$img[0].'" alt="'.$row['title'].'">
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

            $num = $fr['men_num']+$fr['women_num']+$fr['children_num'];
            $f_html .= '<div class="mypageListBoxJ">
								<div class="mypageListBoxJCont">
									<div class="mypageListBoxJCapArea">
										<p class="mypageListBoxCap">'.date("d/M/Y", strtotime($fr['come_date'])).' <br class="hidden-xs">'.date("H:i", strtotime($fr['come_date'])).'</p>
										<p class="mypageListBoxCap">reservation <br class="hidden-xs">for '.$num.'</p>
									</div>
									<div class="mypageListBoxJImgArea">
										<img alt="" src="../upload_files/tour/'.$img[0].'" class="mypageListBoxImg">
									</div>
									<div class="mypageListBoxJTtlArea">
										<h4 class="mypageListBoxJTtl">'.$tour['title'].'</h4>
									</div>
								</div>
								<div class="mypageListBoxJBtnArea mt-n">
									<a href="./booking_details.php?rid='.$fr['reservation_id'].'" class="btnBase btnBg1 btnW1 mypageListBoxJBtn">
										<span class="btnLh2">View the details</span>
									</a>
								</div>
							</div>';

            return $f_html;
        }


        $member_id = $_SESSION['jis']['login_member']['member_id'];
        $now_date = date('Y-m-d H:i:s');

        $f_rvs = $this->common_logic->select_logic("select * from t_reservation where  member_id = ? and come_date >= ?", array($member_id, $now_date));

        $f_html = '';
        foreach ((array)$f_rvs as $fr){
            $tour = $this->jis_common_logic->get_tour($fr['tour_relation_id'], true);
            $f_html = html($fr,$tour['tour']);
        }
        if($f_html == '' || $f_html == null){
            $f_html = '
			<p class="mypageTxt">
				Not registered yet
			</p>';
        }

        $p_rvs = $this->common_logic->select_logic("select * from t_reservation where  member_id = ? and come_date < ?", array($member_id, $now_date));

        $p_html = '';
        foreach ((array)$p_rvs as $pr){

            $tour = $this->jis_common_logic->get_tour($pr['tour_relation_id'], true);
            $p_html = html($pr,$tour['tour']);
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
            $html .='<a href="'.$url.'" class="recentBox">
						<div class="recentBoxImg">
							<img src="'.$path.'upload_files/tour/'.$img[0].'" alt="'.$row['title'].'">
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
        $rev = $this->common_logic->select_logic("select * from t_review where store_id = ? and del_flg = 0 ", array($store_basic_id));
        foreach ((array)$rev as $row){

            $star = str_repeat("★", $row['review_point']) . str_repeat("☆", 5 -$row['review_point']);
            $tour  = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", $row['tour_id']);

            $img = explode(",", $tour[0]['img']);
            $html .= '<div class="revArea">
								<div class="revIm">
									<img class="rankingBoxInImg" src="../update_files/tour/'.$img.'" alt="">
								</div>
								<div class="revTxt">
									<h4 class="reviewAreaTtl">'.$row['create_at'].'</h4>
									<time class="reviewAreaTime">'.date('Y.m.d', strtotime($row['create_at'])).'</time>
									<div class="reviewStar">
										<p>'.$row['nicname'].'</p>
										<p'.$star.'</p>
									</div>
									<p class="reviewStrDetail">'.$row['comment'].'</p>
								</div>
							</div>';

        }

        return $html;
    }














}
?>