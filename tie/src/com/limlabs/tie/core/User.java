package com.limlabs.tie.core;
import java.util.Vector;

import javax.xml.parsers.*;
import org.w3c.dom.*;

public class User {
	
	//User's information
	public int uid;
	public String uname;
	public String email;
	public String address;
	public String lname;
	public String fname;
	public String phone;
	
	public boolean fromXML(Element e) {
		
		if(uid != Integer.parseInt(e.getNodeValue())) 
			return false;
			
		uname = e.getNodeValue();
		email = e.getNodeValue();
		
		return true;
	}
}
