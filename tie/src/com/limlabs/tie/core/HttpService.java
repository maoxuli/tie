package com.limlabs.tie.core;

import java.util.*;
import java.io.*;
import java.net.*;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.w3c.dom.Document;
import org.w3c.dom.Element;

/*
 * Interface with server via http GET and POST
 * 
 */

public class HttpService implements Service {
	
	//Server host
	private String host = "";
	
	//Session string
	private String session_id = "";
	
	//Constructor
	public HttpService(String h) {
		
		host = h;
	}
	
	//Get content from server
	private String getHttpContent(String parameter) {
						
		System.out.printf("HttpService::GET(%s)\r\n", host + parameter);

		//Build text lines
	    StringBuilder content = new StringBuilder();
	    
		try {
		    	
			URL postUrl = new URL(host + parameter);
			HttpURLConnection conn = (HttpURLConnection)postUrl.openConnection();
			if(session_id != "") {
				conn.setRequestProperty("Cookie", session_id);
			}
			
        	BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
	    	
        	 String line;
             while ((line = reader.readLine()) != null)
             {
            	 content.append(line + "\n");
             }
        	
     	     System.out.printf("HttpService::GET content: %s\r\n", content.toString());
	    	 reader.close();     
	        
			if(session_id == "") {
				String cookie = conn.getHeaderField("Set-Cookie");
				session_id = cookie.split(";")[0];
			}
				
			 conn.disconnect();
	    }
	    catch (Exception ex) {
        	System.out.printf("HttpService::GET exception: %s\r\n", ex.getMessage());
	    	return content.toString();
	    }
	    
		return content.toString();	
	}
	
	//Post request to server
	private String postHttpRequest(String parameter, String content) {
		
		System.out.printf("HttpService::POST(%s, %s)\r\n", host + parameter, content);
		
		//Build result text lines
		StringBuilder result = new StringBuilder();
		
        try {
        	
			URL postUrl = new URL(host + parameter);
			HttpURLConnection conn = (HttpURLConnection)postUrl.openConnection();
			
			conn.setDoOutput(true);
			conn.setDoInput(true);
			conn.setRequestMethod("POST");
			conn.setUseCaches(false);
			conn.setInstanceFollowRedirects(true);
			conn.setRequestProperty("Content-Type","application/x-www-form-urlencoded");
			if(session_id != "") {
				conn.setRequestProperty("Cookie", session_id);
			}
			
			conn.connect();
        	
        	DataOutputStream out = new DataOutputStream(conn.getOutputStream());
        	
        	out.writeBytes(content);
     	    System.out.printf("HttpService::POST content: %s\r\n", content);

	    	out.flush();
	    	out.close();
	    	
        	BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));

			String line;
			while ((line = reader.readLine()) != null)
			{
				result.append(line + "\n");
			}
             
     	    System.out.printf("HttpService::POST result: %s\r\n", result.toString());
	    	reader.close();
 
			if(session_id == "") {
				String cookie = conn.getHeaderField("Set-Cookie");
				session_id = cookie.split(";")[0];
			}
			
	    	conn.disconnect();
        }
        catch (Exception ex) {
        	System.out.printf("HttpService::POST exception: %s\r\n", ex.getMessage());
        	return result.toString();
        }
        
		return result.toString();
	}
	
	public boolean login(String credential) {
		
		String result = postHttpRequest("/service.php?c=main&a=login", credential);
		
		try{
			//XML parser factory
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream is = new ByteArrayInputStream(result.getBytes("UTF-8"));
			Document dom = builder.parse(is);
			Element root = dom.getDocumentElement();	
			
			String res = root.getElementsByTagName("result").item(0).getFirstChild().getNodeValue();
			return res.compareToIgnoreCase("OK") == 0;

		}
		catch(Exception ex) {
			System.out.println(ex.getMessage());
		}
		
		return false;
	}

	//Logout
	public boolean logout() {
	
		String result = postHttpRequest("/service.php?c=main&a=logout", "");
		return true;
	}

	//Get current user
	public String viewUser() {
		
		return getHttpContent("/service.php?c=main&a=view");
	}
	
	//Update current user
	public boolean updateUser(String user) {
		
		String result = postHttpRequest("/service.php?c=main&a=update", user);
		return true;
	}
	
	//Friends management: Add friends
	public boolean addFriend(int uid) {

		String result = postHttpRequest("/service.php?c=friends&a=add", "uid=" + uid);
		return true;
	}
	
	//Friends management: Remove friends
	public boolean removeFriend(int uid) {

		String result = postHttpRequest("/service.php?c=friends&a=remove", "uid=" + uid);
		return true;
	}
	
	//Friends management: View friend
	public String viewFriend(int uid) {
		
		return getHttpContent("/service.php?c=friends&a=sview&uid=" + uid);
	}
	
	//Friends management: Get Friends list
	public String getFriends() {
		
		return getHttpContent("/service.php?c=friends&a=listing");
	}
	
	//Friends management: Get waiting list
	public String getWaiting() {
		
		return getHttpContent("/service.php?c=friends&a=waiting");
	}
	
	//Moods management: Get candidate feelings
	public String getFeelings() {
		
		return getHttpContent("/service.php?c=moods&a=feelings");
	}
	
	//Moods management: Set current mood
	public boolean setMood(String mood) {

		String result = postHttpRequest("/service.php?c=moods&a=update", mood);
		return true;
	}
	
	//Moods management: Get user and friends' moods data
	public String getMoods(int uid) {
		
		return getHttpContent("/service.php?c=moods&a=view&uid=" + uid);
	}
		
	//Friends management: Get matching users
	public String getMatching() {

		return getHttpContent("/service.php?c=moods&a=matching");
	}
}
