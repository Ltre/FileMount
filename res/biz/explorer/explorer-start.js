
function expand(folderElem, nodeId){
    if (folderElem.data('closed') == 1) {
        requestExpand(nodeId, function(list){
            folderElem.data('closed', 0);
            folderElem.removeClass('closed').addClass('opened');
            $.each(list, function(i, e){
                renderChildren(folderElem, e);
            });
        });
    } else {
        folderElem.data('closed', 1);
        folderElem.removeClass('opened').addClass('closed');
        folderElem.children('ul').remove();
    }
}


function requestExpand(nodeId, cb){
    var url = '/explorer/expandList/';
    if (nodeId) url += nodeId;
    $.getJSON(url, function(j){
        if (j.code == 0) {
            cb.call(this, j.data);
        }
    });
}


function renderChildren(folderElem, data){
    var liClass = data.is_leaf ? '' : 'folder closed';
    var dataClosed = data.is_leaf ? '' : 'data-closed="1"';
    var tpl = '<ul><li class="item '+liClass+'" data-nodeid="'+data.node_id+'" '+dataClosed+'>';
    tpl += '<button class="item-btn">'+data.node_name+'</button></li></ul>';
    folderElem.append(tpl);
}


$(document).on('click', '.item.folder>.item-btn', function(){
    var folderElem = $(this).parent('.item.folder')
    var nodeId = folderElem.data('nodeid');
    expand(folderElem, nodeId);
});