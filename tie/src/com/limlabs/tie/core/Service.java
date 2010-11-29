package com.limlabs.tie.core;

import java.util.*;

/*
 * Interfce with server 
 * Wrapper complex data into xml string
 * 
 */

public interface Service {
	
	//Around a user
	public boolean login(String credential);
	public boolean logout();
	public String viewUser();
	public boolean updateUser(String user);
	
	//Around friendship
	public boolean addFriend(int uid);
	public boolean removeFriend(int uid);
	public String viewFriend(int uid);
	public String getFriends();
	public String getWaiting();

	//Around moods
	public String getFeelings();
	public boolean setMood(String mood);
	public String getMoods(int uid);
	public String getMatching();
}
