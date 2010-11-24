package com.limlabs.tie.logic;
import java.util.Vector;
import java.util.Map;
import java.util.HashMap;

public class Feelings {
	
	//Feelings list
	private Map<Integer, Feeling> feelings = new HashMap<Integer, Feeling>();
	private Vector<Integer> selection = new Vector<Integer>();
	
	public Feeling getFeeling(int code) {
		return feelings.get(code);
	}
	
	public Vector<Feeling> getFeelings() {
		//Screening selected feelings
		Vector<Feeling> fl = new Vector<Feeling>();
		
		return fl;
	}
	
	public void setSelection(Vector<Integer> sel) {
		selection = sel;
	}
}
