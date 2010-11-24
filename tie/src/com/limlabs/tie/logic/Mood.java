package com.limlabs.tie.logic;

public class Mood {
	
	//Feeling and time
	public int feeling;
	public long time;
	
	public Mood(int code) {
		feeling = code;
		time = System.currentTimeMillis();
	}
}
