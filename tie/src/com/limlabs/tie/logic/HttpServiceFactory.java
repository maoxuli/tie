package com.limlabs.tie.logic;

public class HttpServiceFactory implements ServiceFactory {
	
	public Service createService(String server) {
		//
		Service srv = new HttpService(server);
		
		return srv;
	}
}
