package com.limlabs.tie.logic;

public class RestServiceFactory implements ServiceFactory {
	
	public Service createService() {
		//
		Service srv = new RestService();
		
		return srv;
	}
}
