
USE `filemount`;


INSERT INTO `fmt_node` (`node_id`, `parent_id`, `node_path`, `node_level`, `is_leaf`, `file_id`) VALUES
(1, 0, '1', 0, 0, 0),
(2, 1, '1,2', 1, 1, 0),
(3, 1, '1,3', 1, 1, 0);



INSERT INTO `fmt_tree` (`tree_id`, `root_node`, `uid`) VALUES
(1, 1, 1);
