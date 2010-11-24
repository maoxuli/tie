package com.limlabs.tie.logic;

public class CurrentUser extends User {
	
	//Login and logout
	//Update user's information and moods data
	public String upass;
	public String token;
	
	public boolean login() {
		//Check uname and upass
		
		//Using uname and upass login to get token from server
		
		//If successful, update current user's information and moods data
		
		return true;
	}
	public boolean logout() {
		//Logout from server, release token
		
		//Clean current user's information
		
		return true;
	}

	//Update current mood
	public boolean setMood(int code) {
		Mood md = new Mood(code);
		moods.add(md);
		
		//Update current mood to server
		
		return true;
	}
}
