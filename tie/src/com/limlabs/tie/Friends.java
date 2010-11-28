package com.limlabs.tie;

import com.limlabs.tie.core.*;
import java.util.*;

import android.app.Activity;
import android.os.Bundle;

public class Friends extends Activity {

	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
        setContentView(R.layout.friends);
		
        Master master = Master.instance();
        Vector<Friend> friends = master.getFriends();        
	}
	
	
	
}
