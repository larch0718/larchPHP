use novel;

create table if not exists `tb_author`(
    `id` int(11) unsigned not null auto_increment,
    `name` varchar(64) not null default "" comment '姓名',
    `introduction` varchar(128) not null default "" comment '简介',
    `created_time` int(11) unsigned not null default 0 comment '创建时间',
    `updated_time` int(11) unsigned not null default 0 comment '更新时间',
    primary key (`id`) using btree
)engine=InnoDb default charset=utf8mb4 comment '作者表';

create table if not exists `tb_novel`(
    `id` int(11) unsigned not null auto_increment,
    `name` varchar(64) not null default '' comment '名称',
    `author_id` int unsigned not null default 0 comment '作者id',
    `introduction` varchar(128) not null default '' comment '简介',
    `status` tinyint(4) not null default 1 comment '状态：１连载　２完本　３下架　３停更',
    `created_time` int(11) unsigned not null default 0 comment '创建时间',
    `updated_time` int(11) unsigned not null default 0 comment '更新时间',
    primary key (`id`) using btree,
    key `inx_author`(`author_id`) using btree
)engine=InnoDb default charset=utf8mb4 comment '小说表';