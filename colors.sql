SET NAMES latin1;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `colors` (
  `id` int(6) NOT NULL auto_increment,
  `color` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=latin1;

insert into `colors` values('1','Red'),
 ('2','Blue'),
 ('3','Green'),
 ('4','White'),
 ('5','Black'),
 ('6','Yellow'),
 ('7','Purple'),
 ('8','Dark Green'),
 ('9','Forest Green'),
 ('10','Maroon'),
 ('11','Light Blue'),
 ('12','Dark Blue'),
 ('13','Grey'),
 ('14','Beige'),
 ('15','Brown'),
 ('16','Bronze'),
 ('17','Gold'),
 ('18','Cyan'),
 ('19','Crimson'),
 ('20','Dark Brown'),
 ('21','Dark Grey'),
 ('22','Dark Red'),
 ('23','Salmon'),
 ('24','Sky Blue'),
 ('25','Light Green'),
 ('26','Lime Green'),
 ('27','Hunter Green'),
 ('28','Indigo'),
 ('29','Hot Pink'),
 ('30','Khaki'),
 ('31','Lavender'),
 ('32','Navy Blue'),
 ('33','Rose'),
 ('34','Orange'),
 ('35','Olive'),
 ('36','Orange Red'),
 ('37','Royal Blue'),
 ('38','Teal'),
 ('39','Turquoise'),
 ('40','Violet');


SET FOREIGN_KEY_CHECKS = 1;