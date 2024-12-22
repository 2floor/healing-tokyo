
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Maps JavaScript API Example - simple</title>
    <script src="https://maps.google.com/maps?file=api&v=1&key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc"
        type="text/javascript" charset="utf-8"></script>
  </head>
  <body>
    <div id="map" style="width:500px; height:450px"></div>
    <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {
      var map = new GMap2(document.getElementById("map"));

      var point = new GLatLng(36.03, 139.15);

      map.setCenter(point, 10);


      var imageUrl = "http://www.geekpage.jp/img/geek-title.png";
      var screenXY = new GScreenPoint(50, 100);
      var overlayXY = new GScreenPoint(0, 0);
      var sz = new GScreenSize(200, 100);

      var overlay = new GScreenOverlay(imageUrl, screenXY, overlayXY, sz);

      map.addOverlay(overlay);

    }
    //]]>
    </script>
  </body>

</html>