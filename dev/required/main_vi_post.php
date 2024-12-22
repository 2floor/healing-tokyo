<?php
session_start();
require_once __DIR__ . "/../logic/common/jis_common_logic.php";
require_once __DIR__ . "/../logic/common/common_logic.php";
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();
$area_d = $jis_common_logic->area_array();


$a_opt = '';
foreach ($area_d as $id => $a) {
    $sl = ($_GET['area'] == $id)?'selected="selected"':"";
    $a_opt .= '<option value="'.$id.'" '.$sl.'>'.$a['eng'].'</option>';
}


$num_opt = '';
for ($i = 1; $i < 10; $i++) {
    $sl = ($_GET['num'] == $i)?'selected="selected"':"";
    $num_opt .= '<option value="'.$i.'" '.$sl.'>'.$i.'</option>';
}


$cate_d = $jis_common_logic->category_array();
$cate_opt = '';
foreach ((array)$cate_d as $ca_id => $ca) {
    $sl = ($_GET['cate'] == $ca_id)?'selected="selected"':"";
    $cate_opt .= '<option value="'.$ca_id.'" '.$sl.'>'.$ca['eng'].'</option>';
    $ca_chi = $jis_common_logic->get_cate_child($ca_id);
    foreach ((array)$ca_chi as $cf => $cc) {
        if($cf === 'child'){
            foreach ((array)$cc as $ccc) {
                $sl2 = ($_GET['cate'] == $ccc['category_id'])?'selected="selected"':"";
                $cate_opt .= '<option value="'.$ccc['category_id'].'" '.$sl2.'>　　'.$ccc['category_eng'].'</option>';
            }
        }else{
            $sl2 = ($_GET['cate'] == $cc['category_id'])?'selected="selected"':"";
            $cate_opt .= '<option value="'.$cc['category_id'].'" '.$sl2.'>　'.$cc['category_eng'].'</option>';
        }
    }
}
$size = '';
if(!$_GET['req_index'])$size = 'size2';
?>
<style>



@media all and (-ms-high-contrast:none){
  *::-ms-backdrop,
  .l_form { margin: 0 2%!important; } /* IE11 */
}

</style>
<form action="<?php print $path?>search/" method="get" class="l_form">
	<div class="row justify-content-center mbr-white">
		<div class="searchAreaWrap <?php print $size?> l_in" >
			<div class="searchAreaBox">
				<p class="searchAreaBoxLabel">Category</p>
				<select class="searchAreaBoxSelect" name="cate">
					<option value="">No Select</option>
					<?php print $cate_opt?>
				</select>
			</div>
			<div class="searchAreaBox">
				<p class="searchAreaBoxLabel">Date</p>
				<input class="searchAreaBoxSelect w2 datepicker" name="date" type="text" value="<?php print $_GET['date']?>" readonly="readonly" placeholder="mm/dd/yyyy">
			</div>
			<div class="searchAreaBox">
				<p class="searchAreaBoxLabel">Number</p>
				<select class="searchAreaBoxSelect w3" name="num">
					<option value="">No Select</option>
					<?php print $num_opt?>
				</select>
			</div>
			<div class="searchAreaBox">
				<p class="searchAreaBoxLabel">Area</p>
				<select class="searchAreaBoxSelect w3" name="area">
					<option value="">No Select</option>
					<?php print $a_opt?>
				</select>
			</div>
			<div class="searchAreaBox noMa">
				<button class="searchSubmitBtn"><i class="fas fa-search" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</form>