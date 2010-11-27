package com.limlabs.tie;

import com.limlabs.tie.logic.Friends;

import android.content.Context;
import android.content.res.TypedArray;
import android.util.AttributeSet;
import android.view.View;

import android.widget.*;
import android.os.Bundle;

public class FriendsView extends View {

    public FriendsView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
    }
    
	public FriendsView(Context context, AttributeSet attrs) {
		super(context, attrs);
	}
	
	private Friends fri = new Friends();
	
	private ListView lView;
	private String lv_items[] = { "Android", "iPhone", "BlackBerry",
			"AndroidPeople", "J2ME", "Listview", "ArrayAdapter", "ListItem",
			"Us", "UK", "India" };

	public void onCreate(Bundle icicle) {
		
		LinkList<Friend> fl = fri.getFriends();
		String lv_items[] = new String[];
		
		
		lView = (ListView) findViewById(R.id.ListView01);
		
		lView.setAdapter(new ArrayAdapter<String>(this, android.R.layout.friends, lv_items));
		
		lView.setChoiceMode(ListView.CHOICE_MODE_MULTIPLE);
	}
}
