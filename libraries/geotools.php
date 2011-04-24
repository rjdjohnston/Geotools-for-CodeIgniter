<?php

class Geotools {
	
	private $defaultUnit = 'km';
	private $kmPerMile = 1.609;
	private $earthRadius = array();
	
	public function __construct() {
		$this->earthRadius['miles'] = 3963.19;
		$this->earthRadius['km'] = $this->earthRadius['miles'] * $this->kmPerMile;
	}
	
	public function distanceBetween(Geopoint $pointA, Geopoint $pointB, $algorithm = 'flat', $unit = null) {

		if (!$unit) $unit = $this->defaultUnit;

		switch ($algorithm) {
			case 'haversine':
				$theta = ($pointA->longitude - $pointB->longitude); 
				$dist = sin(deg2rad($pointA->latitude)) * sin(deg2rad($pointB->latitude)) +  cos(deg2rad($pointA->latitude)) * cos(deg2rad($pointB->latitude)) * cos(deg2rad($theta)); 
				$dist = acos($dist); 
				
				$distance = rad2deg($dist);
			break;
			case 'flat':
			default:	
				$distanceEW = ($pointB->longitude - $pointA->longitude) * cos($pointA->latitude);
				$distanceNS = $pointB->latitude - $pointA->latitude;
				
				
				$distance = sqrt( ($distanceEW * $distanceEW) + ($distanceNS * $distanceNS));
			break;
		}
		
		$distance *= 2 * pi() * $this->earthRadius[$unit] / 360.0;
		
		return $distance;
		
	}
	
	public function geopoint($latitude, $longitude) {
		include_once('geopoint.php');
		return new Geopoint((float)$latitude, (float)$longitude);
	}
	
}