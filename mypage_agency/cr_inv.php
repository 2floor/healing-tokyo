<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="sheet.css">
    <title>御請求書</title>
</head>

<body>
    <p class="print_w"><button onclick="window.print(); return false;">PDFで保存する</button></p>
    <section class="sheet">
        <div class="row_1">
            <h1 class="inv text-center">御請求書</h1>
        </div>
        <div class="row_2">
            <ul class="text-right">
                <li><?php print $_GET['inv_date']; ?>分</li>
            </ul>
        </div>
        <div class="row_3">
            <div class="col_1">
                <ul>
                    <li>
                        <h2 class="customer_name"><?php echo $_SESSION['jis']['login_member']['company_name']; ?>様</h2>
                    </li>
                    <li><?php echo $_SESSION['jis']['login_member']['location']; ?></li>
                </ul>
            </div>
            <div class="col_2">
                <ul >
                    <li>
                        <h2>おおた合同会社</h2>
                    </li>
                    〒171-0021 東京都豊島区西池袋５丁目１７番
                </ul>
            </div>
            <div class="clear-element"></div>
        </div>

        <div class="row_4">
            <p>下記のとおりご請求申し上げます。</p>

            <table class="summary inv">
                <tbody>
                    <tr>
                        <th class="sum">合計金額</th>
                        <td class="sum">￥5,500</td>
                    </tr>
                </tbody>
            </table>
            <p class="zei_txt">発行日：<?php print date("Y月m月d日") ?></p>
        </div>

        <div class="row_5">
            <table class="detail inv">
                <thead>
                    <tr>
                        <th class="date">概要</th>
                        <th class="delv">数量</th>
                        <th class="unit_price2">単価</th>
                        <th class="subtotal2">金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>1</td>
                        <td>5000</td>
                        <td>5000</td>
                    </tr>
                    <tr>
                        <td class="space" colspan="4"> </td>
                    </tr>
                </tbody>
            </table>
            <table class="detail inv">
                <tbody>
                    <tr>
                        <th>合計(税抜き) </th>
                        <td>5000</td>
                        <th class="sum">消費税額計 </th>
                        <td class="sum">5500</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
</body>

</html>