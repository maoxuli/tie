package com.limlabs.tie;

import android.app.Activity;
import android.os.Bundle;

import com.limlabs.tie.core.*;
import android.content.Intent;
import android.view.*;
import android.widget.*;
import android.view.View.OnClickListener;
import java.security.*;
import java.math.*;

public class Login extends Activity implements OnClickListener {
	
	//Widgets
	private EditText edt_uname;
	private EditText edt_upass;
	private Button btn_submit;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
        setContentView(R.layout.login);
		
		edt_uname = (EditText)findViewById(R.id.edt_uname);
		edt_upass = (EditText)findViewById(R.id.edt_upass);
		btn_submit = (Button)findViewById(R.id.btn_submit);
		
		btn_submit.setOnClickListener(this);
	}
	
    // Implement the OnClickListener callback
    public void onClick(View v) {
		
    	Master master = Master.instance();
    	
		master.host = "http://app.limlabs.com/tie";
		master.uname = edt_uname.getText().toString();
		master.upass = edt_upass.getText().toString();
		master.login();    
	}  
    

}
