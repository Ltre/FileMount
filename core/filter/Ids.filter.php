<?php
/**
 * 处理ids
 */
class IdsFilter implements DIFilter {
    
    function doFilter() {
        $id_array = Util_::isIdsFormat(arg('ids', []));
        $id_array = Util_::hasZeroInFollowUpOfIds($id_array);
        $GLOBALS['request_args']['ids'] = $id_array;
        
        $parentid_array = Util_::isIdsFormat(arg('parentid', []));
        $parentid_array = Util_::hasZeroInFollowUpOfIds($parentid_array);
        $GLOBALS['request_args']['parentid'] = $parentid_array;
    }
    
}