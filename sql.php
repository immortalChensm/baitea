<?php
	CREATE TABLE tp_liveplay(
	   id int(11) unsigned primary key auto_increment,
	   userid int(11),
	   title varchar(255),
	   live_cover varchar(255) comment '直播封面',
	   live_pixs  char(50) comment '直播率',
	   pluhhurl varchar(255) comment '推流地址',
	   playurl varchar(255) comment '播放地址',
	   status tinyint(1) not null default 0 comment '当前主播状态０是正常推流状态',
	   add_time int comment '开播起始时间',
	   end_time int comment '结束时间'
	);
?>