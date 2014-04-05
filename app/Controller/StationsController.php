<?php
/**
 * This controller is to create and interact with stations
 */

App::uses('AppController', 'Controller');

class StationsController extends AppController {
	public function createStation ( $seed, $lat, $lon, $is_artist ) {
		if ( _isValidLoc( $lat, $lon ) {
			//Create New Station
		}
	}
	
	public function viewStations ( $lat, $lon, $range ) {
		// should show a list of stations in range as determined by distance formula
	}
	
	public function showNearestStation ( $lat, $lon ) {
		// returns closest station to user location
	}
	
	public function favoriteStation ( $station_id ) {
		// adds to user's favorites list
	}
	
	public function playStation ( $station_id ) {
		// puts rdio sdk player into web page, rdio stuff should be partially handeled in view
		// this method should only contain stop, start, and skip
	}
	
	public function vote ( $user, $station_id, $type ) {
		// Voting will be a non-trivial application
		// Items that will be need to be dealt with:
		// * When to apply a change to taste profile (time delay
		time();
	}
	
	public function _isValidLoc( $lat, $lon ) {
		if ( $lat > 90 || $lat < -90 ) {
			// Sorry you are not on the world.
			return false;
		}
		
		if( $lon > 180 || $lon < -180 ) {
			return false;
		}
	}
	
	public function _distanceToLocation( $lat1, $lon1, $lat2, $lon2 ) {
		// add internet code --> GeoDataSource.com (C) All Rights Reserved 2014		   		
	    //function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        //returns distance in miles by default
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
		//$unit = strtoupper($unit);
//remove these lines of you don't need kilometers/nautical miles
		//	  if ($unit == "K") {
		//		return ($miles * 1.609344);
		//	  } else if ($unit == "N") {
		//		  return ($miles * 0.8684);
		//		} else
       return $miles;
		  }
	}
//test cases->
	//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
	//	echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
	//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

	
	
	
	}//here
}
