<?php
class Security {
	
	public static function getSecurityKey($key){
		$first = md5($key);
		$second = md5("navigator684_85w9");
		return md5($first."".$second)."d83kjsdx9wen47fw8fh".md5($second."".$first)."bjdbe9dj2isvbsdj9405nv93".$first."vn39vq784bv93".$second;
	}
}

//echo Security::getSecurityKey(hello);
?>