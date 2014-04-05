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
	
	public function _distanceToLocation( $start_lat, $start_lon, $end_lat, $end_lon ) {
		// add internet code
	}
}
