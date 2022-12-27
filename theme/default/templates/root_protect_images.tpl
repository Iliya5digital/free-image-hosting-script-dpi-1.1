RewriteEngine on
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?$_SERVER[HTTP_HOST] [NC]
RewriteRule \.(jpg|jpeg|png|gif)$ $root_path/theme/$settings[theme]/images/block.jpg [NC,R,L]