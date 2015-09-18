 <!DOCTYPE html>
<html>
<head>
<?php
	$x = 28.6447184;
	$y = 77.3793774;
	echo $x.", ".$y."<br>";
?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBcmYGGYTH1hGEEr31Odpiou8thwx55f_o"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(<?php echo $x.", ".$y; ?>),
    zoom:13,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
  
  var marker=new google.maps.Marker({
  position:new google.maps.LatLng(<?php echo $x.", ".$y; ?>),
  title:"Hello"
  });
  marker.setAnimation(google.maps.Animation.BOUNCE);
  marker.setMap(map);
  
  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Vehicle Number</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Address</b></p>'+
      '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
      'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
      '(last visited June 22, 2009).</p>'+
      '</div>'+
      '</div>';
  
  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div id="googleMap" style="width:1050px;height:550px;"></div>
</body>

</html> 