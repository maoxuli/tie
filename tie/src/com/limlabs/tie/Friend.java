package com.limlabs.tie;

public class Friend extends User {
	int status;
	int time;
	List<Mood> moods;
	
	Mood GetMood();
	List<Mood> GetMoods();
}
