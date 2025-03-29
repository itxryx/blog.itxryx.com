SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

create table if not exists author (
                                      id                      bigint unsigned auto_increment comment '投稿者ID' primary key,
                                      created_at              bigint       not null comment '作成日時（UNIXTIME）',
                                      updated_at              bigint       not null comment '更新日時（UNIXTIME）',
                                      registered_at           bigint       not null comment '登録日時（UNIXTIME）',
                                      login_id                varchar(255) not null comment 'ログインID',
                                      email                   varchar(255) not null comment 'メールアドレス',
                                      hashed_password         varchar(255) not null comment 'ハッシュ化済みパスワード',
                                      profile_image_file_path varchar(255) null comment 'プロフィール画像ファイルパス',
                                      constraint uq_author_email unique (email),
                                      constraint uq_author_login_id unique (login_id)
) comment '投稿者テーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create table if not exists post_status (
                                           id     bigint unsigned auto_increment comment 'ステータスID' primary key,
                                           status varchar(100) not null comment 'ステータス名'
) comment '投稿ステータステーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create table if not exists post (
                                    id             bigint unsigned auto_increment comment '投稿ID' primary key,
                                    created_at     bigint          not null comment '作成日時（UNIXTIME）',
                                    updated_at     bigint          not null comment '更新日時（UNIXTIME）',
                                    published_at   bigint          null comment '公開日時（UNIXTIME）',
                                    post_id        varchar(255)    not null comment '投稿ID（slug）',
                                    author_id      bigint unsigned not null comment '投稿者ID',
                                    title          varchar(255)    not null comment '投稿タイトル',
                                    body           text            not null comment '投稿本文',
                                    post_status_id bigint unsigned not null comment '投稿ステータスID',
                                    constraint post_ibfk_1 foreign key (author_id) references author (id),
                                    constraint post_ibfk_2 foreign key (post_status_id) references post_status (id)
) comment '投稿テーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create index idx_post_author_id on post (author_id);
create index idx_post_post_status_id on post (post_status_id);

create table if not exists post_media (
                                          id              bigint unsigned auto_increment comment 'メディアID' primary key,
                                          created_at      bigint          not null comment '作成日時（UNIXTIME）',
                                          updated_at      bigint          not null comment '更新日時（UNIXTIME）',
                                          post_id         bigint unsigned not null comment '投稿ID',
                                          media_mime_type varchar(255)    not null comment 'MIMEタイプ',
                                          file_path       varchar(1024)   not null comment 'ファイルパス',
                                          thumbnail_path  varchar(1024)   null comment 'サムネイルファイルパス',
                                          alt_text        varchar(255)    null comment 'alt属性用テキスト',
                                          file_size       int unsigned    not null comment 'ファイルサイズ（bytes）',
                                          constraint post_media_ibfk_1 foreign key (post_id) references post (id)
) comment '投稿メディアテーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create index idx_post_media_post_id on post_media (post_id);

create table if not exists post_tag (
                                        id         bigint unsigned auto_increment comment 'タグID' primary key,
                                        created_at bigint       not null comment '作成日時（UNIXTIME）',
                                        updated_at bigint       not null comment '更新日時（UNIXTIME）',
                                        name       varchar(100) not null comment 'タグ名',
                                        constraint uq_post_tag_name unique (name)
) comment '投稿タグテーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create table if not exists post_tagging (
                                            id         bigint unsigned auto_increment comment '投稿タグ付けID' primary key,
                                            created_at bigint          not null comment '作成日時（UNIXTIME）',
                                            updated_at bigint          not null comment '更新日時（UNIXTIME）',
                                            post_id    bigint unsigned not null comment '投稿ID（post.id）',
                                            tag_id     bigint unsigned not null comment 'タグID（post_tag.id）',
                                            constraint unique_post_tag unique (post_id, tag_id),
                                            constraint post_tagging_ibfk_1 foreign key (post_id) references post (id),
                                            constraint post_tagging_ibfk_2 foreign key (tag_id) references post_tag (id)
) comment '投稿タグ付け中間テーブル'
    default charset = utf8mb4
    collate = utf8mb4_unicode_ci;

create index idx_post_tagging_tag_id on post_tagging (tag_id);
