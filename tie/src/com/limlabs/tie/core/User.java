package com.limlabs.tie.core;
import java.util.Vector;

import javax.xml.parsers.*;
import org.w3c.dom.*;

public class User {
	
	//User's information
	public int uid = 0;
	public String uname = "";
	public String email = "";
	public String lname = "";
	public String fname = "";
	public String phone = "";
	public String address = "";
	
	public boolean fromXML(Element u) {
		
		uid = Integer.parseInt(u.getElementsByTagName("uid").item(0).getFirstChild().getNodeValue());
		uname = u.getElementsByTagName("uname").item(0).getFirstChild().getNodeValue();
		email = u.getElementsByTagName("email").item(0).getFirstChild().getNodeValue();
		lname = u.getElementsByTagName("lname").item(0).getFirstChild().getNodeValue();
		fname = u.getElementsByTagName("fname").item(0).getFirstChild().getNodeValue();
		
		return true;
	}
	
	protected void user_info_dump() {
		System.out.println(uid);
		System.out.println(uname);
		System.out.println(email);
		System.out.println(lname);
		System.out.println(fname);
		System.out.println(address);
		System.out.println(phone);
	}
}
