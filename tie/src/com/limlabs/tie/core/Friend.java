package com.limlabs.tie.core;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.Vector;

import javax.xml.parsers.*;

import org.w3c.dom.*;

public class Friend extends User {

	//Friendship and related time
	public int status;
	public long time;
	
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
	
	public boolean fromXML(Element e) {
		
		uid = Integer.parseInt(e.getElementsByTagName("uid").item(0).getNodeValue());
		
		//Get current user's information
		String us = service.getUser(uid);
		
		try{
			//XML parser factory
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream is = new ByteArrayInputStream(us.getBytes("UTF-8"));
			Document dom = builder.parse(is);
			Element root = dom.getDocumentElement();
			
			fromXML((Element)root.getElementsByTagName("uid").item(0).getFirstChild());
			
			status = Integer.parseInt(e.getElementsByTagName("status").item(0).getFirstChild().getNodeValue());
			time = Long.parseLong(e.getElementsByTagName("time").item(0).getFirstChild().getNodeValue());
		}
		catch(Exception ex) {
			System.out.println("Master::login() user xml parser exception:" + ex.getMessage());
		}
		
		return true;
	}
}
