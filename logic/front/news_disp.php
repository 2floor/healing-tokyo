<?php
require_once __DIR__ .  '/../../logic/common/common_logic.php';
class news_disp {
	private $comm_logic;

	public function __construct(){
		$this->common_logic = new common_logic();
	}

	/**
	 * リスト・ページャー生成
	 * @param unknown $disp_num
	 * @param unknown $now
	 * @param unknown $add
	 * @return string[]
	 */
	public function get_news_list($disp_num, $now, $add = null){
		//現在のページ（GETパラメータ[now]にて取得）
		//※現在の表示ページ番号 != $now_pageであるので注意
		//※現在の表示ページ番号 == $now_page + 1 である
		$now_page = 0;
		if($now != null && $now != ''){
			$now_page = $now;
		}

		$where_p_base = array();

		//総件数
		$count_data = $this->common_logic->select_logic("select count(news_id) AS `cnt` from t_news where del_flg = 0 and public_flg = 0 and disp_date <= CURDATE() order by disp_date desc ", array());
		$all_cnt = $count_data[0]['cnt'];

		//総ページ数
		$page_num = ceil($all_cnt / $disp_num);

		$limit = $disp_num;
		$offset = $now_page * $disp_num;
		array_push($where_p_base, $limit, $offset);

		//データ取得
		$data = $this->common_logic->select_logic("select * from t_news where del_flg = 0 and public_flg = 0 and disp_date <= CURDATE() order by disp_date desc  LIMIT ? OFFSET ? ", $where_p_base);

		//HTML生成
		$now_disp_cnt=$offset;

		$html = '';
		foreach((array)$data as $row){
			$html .= $this->create_html($row, 1);
		}

		if($html == '' || $html == null){
			$html = '<p class="noN">現在公開中の記事はありません。</p>';
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

				if ($disp_i == $max_page) {
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
				'html' => $html,
				'pager' => $pager,
		);

	}


	/**
	 * HTML生成
	 */
	private function create_html($row_base, $type){
		$row = $this->news_conv($row_base);

		if($type == '1'){
			$html = "";
		}else{
			$html = "";
		}

		return $html;

	}

	/**
	 * 各種コンバート
	 */
	private function news_conv($row){
		$title = $row['title'];
		$title_min = mb_substr($row['title'], 0, 20, "UTF-8");

		$detail = nl2br($row['detail']);
		$detail_min = mb_substr($row['detail'], 0, 20, "UTF-8");

		$date = date('Y年m月d日', strtotime($row['disp_date']));

		$img = '<img src="upload_files/news/'.$row["img"].'">';

		return array(
				'title' => $title,
				'title_min' => $title_min,
				'detail' => $detail,
				'detail_min' => $detail_min,
				'date' => $date,
				'img' => $img,
				'base_row' => $row,
		);
	}

}
