package com.limlabs.tie.logic;

public interface Service {
	
	public boolean login(String credential);
	public boolean logout();
	public String getUser();
	public boolean setUser(String user);
	
	public String getFeelings();
	public String getMoods(int uid);
	public boolean setMood(String mood);
	
	public String getFriends();
	public String getWaiting();
	public String getMatching();
	public boolean addFriends(String friends);
	public boolean removeFriends(String friends);
	
}
