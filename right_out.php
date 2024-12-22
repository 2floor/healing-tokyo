<?php
require_once __DIR__ . '/./logic/front/front_disp_logic.php';
require_once __DIR__ . "/./logic/common/common_logic.php";
$front_disp_logic = new front_disp_logic();
$common_logic = new common_logic();

$wad = '';
if ($_GET['cate']) {
    $wad = '&cate=' . $_GET['cate'];
} elseif ($_GET['area']) {
    $wad = '&area=' . $_GET['area'];
}

$ad_res = $common_logic->select_logic_no_param("select * from t_ad where del_flg = '0' and public_flg = '0' ORDER BY RAND() LIMIT 10 ");

$ad_html = '';
for ($i = 0; $i < count($ad_res); $i++) {
    $ad_row = $ad_res[$i];
    $ad_html .= '
    <section>
		<div class="prts__contents_12">
			<div class="cmsi__banner">
				<div class="cmp__banner-item">
					<a href="' . $ad_row['ad_eng'] . '" style="height:50px" target="_blank">
                        <img src="' . $path . 'upload_files/ad/' . $ad_row['thumbnail'] . '" alt="" class=" ">
					</a>
				</div>
			</div>
		</div>
	</section>';
}


?>

<div class="container300">
    <section>
        <div class="prts__top-aside-link_02">
            <div class="cmsi__right-area-head cmsi__head">
                <h4 class="cmp__head__title jisTtlArea"><img src="<?php print $path ?>img/ttl_icon.png" alt="Fuji">Calendar
                </h4>
            </div>

            <div class="cmm__right-area-box">
                <div class="cmsi__link-box02">
                    <div class="calendar-container">
                        <div class="datepicker"></div>
                    </div>
                </div>
            </div>


        </div>
    </section>


    <section style="margin-top: 50px">
        <div class="prts__contents_12">
            <p class="top_bannertxt">Recently viewed</p>
        </div>
    </section>

    <section>
        <div class="prts__contents_12">
            <div class="cmsi__banner">
                <?php print $front_disp_logic->create_recent_view($path); ?>
            </div>
        </div>
    </section>

    <?php print $ad_html ?>


    <!-- /広告エリア-->
</div>

<style>
    .datepicker table tr td,
    .datepicker table tr th {
        width: auto;
        height: auto;
        text-align: center;
        padding: 10px 10px;
        background-color: #ffffff;
        color: #000;
        box-sizing: border-box;
    }

    .datepicker table tr td.today.day {
        background: #F7DEDE !important;
        color: #ffffff !important;
    }

    .datepicker table tr td.highlight {
        background: #ECAAAA !important;
        color: #ffffff !important;
    }

    .datepicker table tr td.today {
        background: #ffffff !important;
        color: #000 !important;
    }
</style>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    const searchPath = "<?php print $path ?>search?date=";

    $(document).ready(function () {
        if (!$('.datepicker').hasClass('hasDatepicker')) {
            $('.datepicker').datepicker({
                format: "mm/dd/yyyy",
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (e) {
                const selectedDate = e.format();
                localStorage.setItem('selectedDate', selectedDate);
                window.location.href = searchPath + encodeURIComponent(selectedDate);
            });
        }

        const selectedDate = localStorage.getItem('selectedDate');
        if (selectedDate) {
            const [month, day, year] = selectedDate.split('/');

            $('.datepicker table tr td').each(function () {
                const cellDate = $(this).text().trim();
                if (cellDate === day) {
                    $(this).addClass('highlight');
                }
            });
        }
    });

</script>


