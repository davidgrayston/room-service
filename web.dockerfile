
FROM nginx:1.15.6

ADD vhost.conf /etc/nginx/conf.d/default.conf
