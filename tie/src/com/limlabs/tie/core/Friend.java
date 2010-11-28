package com.limlabs.tie.core;

import java.util.Vector;


public class Friend extends User {

	//Friendship and related time
	public int status;
	public long time;
	
	//Service
	private Service service = null;
	
	//Friend's moods
	private Vector<Mood> moods = new Vector<Mood>();
	
	public Friend(Service s) {
		
		service = s;
	}
		
	//Get current mood
	public Mood getMood() {
		
		return moods.lastElement();
	}
	
	//Moods
	public Vector<Mood> getMoods() {
		
		return moods;
	}
}
