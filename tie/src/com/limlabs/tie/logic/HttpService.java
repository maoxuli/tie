package com.limlabs.tie.logic;

import java.net.*;
import java.io.*;


public class HttpService implements Service {
	
	//Input and output
	private String session = null;
	private String host = null;
	
	//Constructor
	public HttpService(String server) {
		
		host = server;
	}
	
	//Get content from server
	private String getHttpContent(String parameter) {
		
		String result = null;
		try {
		    	
			URL postUrl = new URL(host + parameter);
			HttpURLConnection conn = (HttpURLConnection)postUrl.openConnection();
			conn.connect();
			
			int response = conn.getResponseCode();
	        if (response == HttpURLConnection.HTTP_OK) {
	        	
	        	BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
		    	
		    	reader.close();
	        }      
	        
			conn.disconnect();
	    }
	    catch (Exception ex) {
	    	return result;
	    }
	    
		return result;	
	}
	
	//Post request to server
	private boolean postHttpRequest(String parameter, String content) {
		
        try {
        	
			URL postUrl = new URL(host + parameter);
			HttpURLConnection conn = (HttpURLConnection)postUrl.openConnection();
			conn.setDoOutput(true);
			conn.setDoInput(true);
			conn.setRequestMethod("POST");
			conn.setUseCaches(false);
			conn.setInstanceFollowRedirects(true);
			conn.setRequestProperty("Content-Type","application/x-www-form-urlencoded");
			conn.connect();
			
			int response = conn.getResponseCode();
            if (response == HttpURLConnection.HTTP_OK) {
            	
            	DataOutputStream out = new DataOutputStream(conn.getOutputStream());
            	BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            	
    	    	out.flush();
    	    	out.close();
    	    	
    	    	reader.close();
            }   
            
        	conn.disconnect();
        }
        catch (Exception ex) {
        	return false;
        }
        
		return true;
	}
    
	//Login
	public boolean login(String credential) {
		
		return postHttpRequest(host + "/service.php?c=main&a=login", credential);
	}
	
	//Logout
	public boolean logout() {
	
		return postHttpRequest(host + "/service.php?c=main&a=logout", "");
	}

	//Get current user
	public String getUser() {
		
		return getHttpContent(host + "/service.php?c=main&a=view");
	}
	
	//Update current user
	public boolean setUser(String user) {
		
		return postHttpRequest(host + "/service.php?c=main&a=update", user);
	}
	
	//Moods management: Get candidate feelings
	public String getFeelings() {
		
		return getHttpContent(host + "/service.php?c=moods&a=feelings");
	}
	
	//Moods management: Get user and friends' moods data
	public String getMoods(int uid) {
		
		return getHttpContent(host + "/service.php?c=moods&a=view&uid=" + uid);
	}
	
	//Moods management: Set current mood
	public boolean setMood(String mood) {

		return postHttpRequest(host + "/service.php?c=moods&a=update", mood);
	}
		
	//Friends management: Get Friends list
	public String getFriends() {
		
		return getHttpContent(host + "/service.php?c=friends&a=listing");
	}
	
	//Friends management: Get waiting list
	public String getWaiting() {
		
		return getHttpContent(host + "/service.php?c=friends&a=waiting");
	}
	
	//Friends management: Get matching users
	public String getMatching() {

		return getHttpContent(host + "/service.php?c=friends&a=matching");
	}
	
	//Friends management: Add friends
	public boolean addFriends(String friends) {

		return postHttpRequest(host + "/service.php?c=friends&a=add", friends);
	}
	
	//Friends management: Remove friends
	public boolean removeFriends(String friends) {

		return postHttpRequest(host + "/service.php?c=friends&a=remove", friends);
	}
}
