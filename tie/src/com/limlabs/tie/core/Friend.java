package com.limlabs.tie.core;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.Vector;

import javax.xml.parsers.*;

import org.w3c.dom.*;

public class Friend extends User {

	//Friendship and related time
	public int status;
	public String time;
	
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
	
	public boolean fromXML(Element f) {
		
		try{
			uid = Integer.parseInt(f.getElementsByTagName("uid_2").item(0).getFirstChild().getNodeValue());
			status = Integer.parseInt(f.getElementsByTagName("status").item(0).getFirstChild().getNodeValue());
			time = f.getElementsByTagName("time").item(0).getFirstChild().getNodeValue();
			
			//Get current user's information
			String us = service.viewFriend(uid);

			//XML parser factory
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream is = new ByteArrayInputStream(us.getBytes("UTF-8"));
			Document dom = builder.parse(is);
			Element root = dom.getDocumentElement();
			super.fromXML((Element)root.getElementsByTagName("user").item(0));
			user_info_dump();
		}
		catch(Exception ex) {
			System.out.println("Friend::fromXML() user xml parser exception:" + ex.getMessage());
		}
		
		return true;
	}
}
