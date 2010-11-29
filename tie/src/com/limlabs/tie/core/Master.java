package com.limlabs.tie.core;

import javax.xml.parsers.*;
import org.w3c.dom.*;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.*;
import java.io.*;


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
		
		if(service == null)
			service = new HttpService(host);
		
		String credential = "uname=" + uname + "&upass=" + md5(upass);
		uid = service.login(credential);
		System.out.printf("Master::login() uid=%d\r\n", uid);
		
		if(uid == 0)
			return false;
		
		//Get current user's information
		String us = service.getUser(uid);
		
		try{
			//XML parser factory
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream is = new ByteArrayInputStream(us.getBytes("UTF-8"));
			Document dom = builder.parse(is);
			Element root = dom.getDocumentElement();
			System.out.println("test");
			
			fromXML((Element)root.getElementsByTagName("uid").item(0).getFirstChild());
		}
		catch(Exception ex) {
			System.out.println("Master::login() user xml parser exception:" + ex.getMessage());
		}
		
		return true;
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

		Vector<Friend> friends = new Vector<Friend>();
		
		if(service != null) {
			
			String fs = service.getFriends();
			friends.clear();
			
			try{
				//XML parser factory
				DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
				DocumentBuilder builder = factory.newDocumentBuilder();
				InputStream is = new ByteArrayInputStream(fs.getBytes("UTF-8"));
				Document dom = builder.parse(is);
				Element root = dom.getDocumentElement();
				
				NodeList nodes = root.getElementsByTagName("Friend");
				for(int i=0; i<nodes.getLength(); i++) {
					
					Friend fri = new Friend(service);
					fri.fromXML((Element)nodes.item(i).getFirstChild());
					friends.add(fri);
				}
			}
			catch(Exception ex) {
				System.out.println("Master::Login() friends xml parser exception:" + ex.getMessage());
			}		
		}

		return friends;
	}
	
	//Friends
	public Vector<Friend> getWaiting() {
		
		return friends;
	}
	
}
