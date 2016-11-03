USE `filemount`;

INSERT INTO `fmt_file` (`file_id`, `sha1`, `mimetype`, `filesize`, `fileext`, `filename`, `rootdir`, `filepath`, `fullpath`, `create_time`, `update_time`) VALUES
(1, 'f4d5s6f4dsf8ds4fs9df4sdf89sdf', 'image/jpeg', 15699, 'jpg', '123.jpg', '/home', 'abc/123.jpg', '/home/abc/123.jpg', 0, '2016-11-03 16:16:57');

INSERT INTO `fmt_node` (`node_id`, `parent_id`, `node_path`, `node_level`, `is_leaf`, `file_id`) VALUES
(1, 0, '1', 0, 0, 0),
(2, 1, '1,2', 1, 1, 1),
(3, 1, '1,3', 1, 1, 1);



INSERT INTO `fmt_tree` (`tree_id`, `root_node`, `uid`) VALUES
(1, 1, 1);