<?php
/**
 * This controller is to create and interact with stations
 */

App::uses('AppController', 'Controller');


class UsersController extends AppController {
	public function createNewUser( $username, $password ) {
		// Creates new User
	}
	
	public function login ( $username, $password ) {
		// logs user in
	}
	
	public function viewFavorites ( $username ) {
		// loads users Favorite Stations
	}
}
