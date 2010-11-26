package com.limlabs.tie.logic;

public class HttpServiceFactory implements ServiceFactory {
	
	public Service createService() {
		//
		Service srv = new RestService();
		
		return srv;
	}
}
