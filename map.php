<?php

$map = $_GET['map'];
$pl = $_GET['pl'];
$bots = $_GET['bot'];
$max = $_GET['max'];
$hostname = $_GET['host'];

if(preg_match("/.*\/(.*?)$/",$map,$map_))
				$clean_map = $map_[1];
else $clean_map = $map;
?>
<div class="map">
<table class="maptable" cellpadding="0" cellspacing="0" height="100%" align="center">
<td colspan="2" class="mapbody"><div class="mapheader" style="text-align:center; font-size:12px;"><?php echo $hostname; ?></div>
<img src="maps/<?php echo $clean_map; ?>.png" width="100%;" />
</td></tr>
<tr><td width="100%" colspan="2" class="mapheader" style="text-align:center;"><?php echo $clean_map; ?></td></tr><tr><td>Online Players:</td><td><?php echo $pl.'('.$bots.')'; ?>/<?php echo $max; ?></td></tr><tr><td>Status:</td><td>Online</td></tr></table><br />
<?php echo "<script language='JavaScript'>\n<!--;\n\nresizeIframe(map);\n\n//-->\n</script>";
 ?>