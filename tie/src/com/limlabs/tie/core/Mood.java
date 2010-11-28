package com.limlabs.tie.core;

public class Mood {
	
	//Feeling and time
	public int feeling;
	public long time;
	
	public Mood(int fid) {
		feeling = fid;
		time = System.currentTimeMillis();
	}
}
