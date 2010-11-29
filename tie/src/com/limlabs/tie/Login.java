package com.limlabs.tie;

import com.limlabs.tie.core.*;
import java.security.*;
import java.math.*;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class Login extends Activity implements OnClickListener {
	
	//Widgets
	private EditText edt_uname;
	private EditText edt_upass;
	private Button btn_submit;
	
	//Main menu
	private Button btn_moods;
	private Button btn_friends;
	private Button btn_matching;
	private Button btn_logout;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
        setContentView(R.layout.login);
		
		edt_uname = (EditText)findViewById(R.id.edt_uname);
		edt_upass = (EditText)findViewById(R.id.edt_upass);
		btn_submit = (Button)findViewById(R.id.btn_submit);
		btn_submit.setOnClickListener(this);
		
		//Main menu
		btn_moods = (Button)findViewById(R.id.btn_moods);
		btn_friends = (Button)findViewById(R.id.btn_friends);
		btn_matching = (Button)findViewById(R.id.btn_matching);
		btn_logout = (Button)findViewById(R.id.btn_logout);
		btn_moods.setOnClickListener(this);
		btn_friends.setOnClickListener(this);
		btn_matching.setOnClickListener(this);
		btn_logout.setOnClickListener(this);
	}
	
    // Implement the OnClickListener callback
    public void onClick(View v) {
		
    	if (v.equals(btn_moods)) {
    		//Switch to Moods activity
    		//Intent myIntent = new Intent(v.getContext(), Moods.class);
            //startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_friends)) {
    		//Switch to Friends activity
    		//Intent myIntent = new Intent(v.getContext(), Friends.class);
            //startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_matching)) {
    		//Switch to Matching activity
    		//Intent myIntent = new Intent(v.getContext(), Matching.class);
            //startActivityForResult(myIntent, 0);
    	}
    	else if (v.equals(btn_logout)) {
    		//Switch to Login activity
    		//Intent myIntent = new Intent(v.getContext(), Login.class);
            //startActivityForResult(myIntent, 0);
    	}
    	else if(v.equals(btn_submit)) {
    		//Login
	    	Master master = Master.instance();
	    	
			master.host = "http://app.limlabs.com/tie";
			master.uname = edt_uname.getText().toString();
			master.upass = edt_upass.getText().toString();
			if(master.login()) {
	    		//Switch to Moods activity
	    		Intent myIntent = new Intent(v.getContext(), Moods.class);
	            startActivityForResult(myIntent, 0);
			}
    	}	
	}  
}
