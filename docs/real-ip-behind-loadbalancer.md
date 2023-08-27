# Getting the real IP of the client behind a load balancer
If you use this container behind a proxy or load balancer you might want to get the real IP of the client instead of the IP of the proxy or load balancer.

To do this you can add the following configuration to the [Nginx configuration](../config/nginx.conf):

```nginx
set_real_ip_from <CIDR>

real_ip_header X-Forwarded-For;
real_ip_recursive on;
```

Where `<CIDR>` is the CIDR of your proxy or load balancer, see the [Nginx documentation](http://nginx.org/en/docs/http/ngx_http_realip_module.html#set_real_ip_from). The real IP of the client will now be available in PHP under `$_SERVER['REMOTE_ADDR']`.