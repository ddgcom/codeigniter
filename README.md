###################
Install CodeIgniter Project By DDG.COM.CO
###################

1) Init Project
composer update

2) Update the url of base_url
source = CodeIgniter/application/config/config.php

3) Setup database 
source = CodeIgniter/application/config/database.php

4) Init database: Go to __URL_PATH__/index.php/main/install or create table into database
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `select` tinyint NOT NULL,
  `file_url` varchar(250) CHARACTER SET utf8 NOT NULL,
  `multiselect` varchar(250),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=201 ;

INSERT INTO `users` (`username`,`password`,`select`,`file_url`,`multiselect`) VALUES 
('diego','123',1,'test-2.pdf','1,2,3'),
('juan','123',1,'test-2.pdf','1,3'),
('pedro','123',3,'test-2.pdf','3'),
('camilo','123',2,'test-2.pdf','2');

Optional) Create file .htaccess and paste (delete url index.php) 
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
