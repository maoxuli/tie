package com.limlabs.tie.logic;

import java.util.Vector;

public class User {
	
	//User's information
	public String uname;
	public String email;
	public String address;
	public String lname;
	public String fname;
	public String phone;
	
	//User's moods
	//Vector, last element is current mood
	protected Vector<Mood> moods = new Vector<Mood>();
	
	public Mood getMood() {
		return moods.lastElement();
	}
	
	public Vector<Mood> getMoods() {
		return moods;
	}	
	
}
