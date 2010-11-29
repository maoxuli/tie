package com.limlabs.tie;

import com.limlabs.tie.core.*;
import java.util.*;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

public class Friends extends Activity implements OnClickListener {
	
	//Main menu
	private Button btn_moods;
	private Button btn_friends;
	private Button btn_matching;
	private Button btn_logout;
	private ListView friendList;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
        setContentView(R.layout.friends);
        
        //Main menu
		btn_moods = (Button)findViewById(R.id.btn_moods);
		btn_friends = (Button)findViewById(R.id.btn_friends);
		btn_matching = (Button)findViewById(R.id.btn_matching);
		btn_logout = (Button)findViewById(R.id.btn_logout);
		btn_moods.setOnClickListener(this);
		btn_friends.setOnClickListener(this);
		btn_matching.setOnClickListener(this);
		btn_logout.setOnClickListener(this);
		
		friendList = (ListView)findViewById(R.id.friend_list);
		
		//Get friends list via Master
		Master master = Master.instance();
		Vector<Friend> friends = master.getFriends();
        friendList.setAdapter(new ArrayAdapter<String>(this, 
       		 android.R.layout.simple_expandable_list_item_1,getData())); 
		
	}
	
	// Implement the OnClickListener callback
    public void onClick(View v) {
    	
    	if (v.equals(btn_moods)) {
    		//Switch to Moods activity
    		Intent myIntent = new Intent(v.getContext(), Moods.class);
            startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_friends)) {
    		//Switch to Friends activity
    		//Intent myIntent = new Intent(v.getContext(), Friends.class);
            //startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_matching)) {
    		//Switch to Matching activity
    		Intent myIntent = new Intent(v.getContext(), Matching.class);
            startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_logout)) {
    		//Switch to Login activity
    		Intent myIntent = new Intent(v.getContext(), Login.class);
            startActivityForResult(myIntent, 0);
    	}
    }
    
    private List<String> getData(){  
 List<String> data = new ArrayList<String>();  
 		data.add("1111111");  
 		data.add("2222222");  
		data.add("3333333");  
		data.add("4444444");  

		return data;  
    }  


    
    
}

