package com.limlabs.tie.logic;

public class CurrentUser extends User {
	String password;
	List<Mood> moods;
	
	Bool Login();
	Bool Logout();

	Bool SetMood(int code);
	Mood GetMood();
	List<Mood> GetMoods();
}
