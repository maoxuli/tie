package com.limlabs.tie.core;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.*;

public class Master extends User {

	//Authorization credential
	public String upass;
	public String host;
	
	//Master's feelings
	private Vector<Feeling> feelings = new Vector<Feeling>();
	
	//Master's moods
	private Vector<Mood> moods = new Vector<Mood>();
	
	//Master's Friends
	private Vector<Friend> friends = new Vector<Friend>();
		
	//Master's service
	private Service service = null;
	
	//
	static private Master _instance = null;
	
	//Constructor
	private Master() {
		
	}
	
	static public Master instance() {
		
		if(null == _instance)
			_instance = new Master();
		
		return _instance;
	}
	
    //Generage md5 of password
    static private String md5(String pInput) {
    	try {
	    	MessageDigest lDigest = MessageDigest.getInstance("MD5");
	    	lDigest.update(pInput.getBytes());
	    	BigInteger lHashInt = new BigInteger(1, lDigest.digest());
	    	return String.format("%1$032X", lHashInt);
	    } 
    	catch(NoSuchAlgorithmException lException) {
    		throw new RuntimeException(lException);
	    }
    }
    
	//Login
	public boolean login() {
		
		service = new HttpService(host);
		
		String credential = "uname=" + uname + "&upass=" + md5(upass);
		service.login(credential);
		
		return false;
	}
	
	//Logout
	public boolean logout() {
		
		return false;
	}
	
	//Feelings
	public Vector<Feeling> getFeelings() {
		
		return feelings;
	}
	
	//Set current mood
	public boolean setMood(int fid) {
		
		Mood md = new Mood(fid);
		moods.add(md);
				
		return true;
	}
	
	//Get current mood
	public Mood getMood() {
		
		return moods.lastElement();
	}
	
	//Moods
	public Vector<Mood> getMoods() {
		
		return moods;
	}
	
	//Add friend
	public boolean addFriend(int uid) {
		
		return false;
	}
	
	//Remove friend
	public boolean removeFriend(int uid) {
		
		return false;
	}
	
	//Friends
	public Vector<Friend> getFriends() {

		
		service.getFriends();

		return friends;
	}
	
	//Friends
	public Vector<Friend> getWaiting() {
		
		return friends;
	}
}
