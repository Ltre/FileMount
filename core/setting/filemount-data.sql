USE `filemount`;


INSERT INTO `fmt_file` (`file_id`, `sha1`, `mimetype`, `filesize`, `fileext`, `filename`, `rootdir`, `filepath`, `fullpath`) VALUES
(1, 'f4d5s6f4dsf8ds4fs9df4sdf89sdf', 'image/jpeg', 15699, 'jpg', '123.jpg', '/home', 'abc/123.jpg', '/home/abc/123.jpg');


INSERT INTO `fmt_node` (`node_id`, `parent_id`, `node_path`, `node_level`, `is_leaf`, `file_id`, `create_time`, `update_time`) VALUES
(1, 0, '1', 0, 0, 0, '2016-11-04 09:06:00', '2016-11-04 09:06:00'),
(2, 1, '1,2', 1, 1, 1, '2016-11-04 09:06:00', '2016-11-04 09:06:00'),
(3, 1, '1,3', 1, 1, 1, '2016-11-04 09:06:00', '2016-11-04 09:06:00'),
(4, 1, '1,4', 1, 0, 1, '2016-11-04 09:38:46', '2016-11-04 09:38:46'),
(5, 4, '1,4,5', 2, 1, 1, '2016-11-04 09:39:39', '2016-11-04 09:39:39'),
(6, 4, '1,4,6', 2, 1, 1, '2016-11-04 09:39:59', '2016-11-04 09:39:59');


INSERT INTO `fmt_tree` (`tree_id`, `root_node`, `uid`) VALUES
(1, 1, 1);
