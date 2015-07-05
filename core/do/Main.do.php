<?php
class MainDo extends DIDo {
    
    function start(){
        $xml = new XMLUtil("1.0", "UTF-8");
        $root = $xml->loadGlobalAndGetRootElement();
        $listHTML = $xml->generatelistHTMLformSubElements($root);
        $contentHTML = $xml->generateContentHTMLfromSubElements($root);
        $pathnavyHTML = '<li id="path_0" class="active">'.@$root->getAttribute("name").' <span class="divider">/</span></li>';
        //将生成的片段转交到admin视图
        $this->args = array(
            'listHTML'=>$listHTML,
            'contentHTML'=>$contentHTML,
            'pathnavyHTML'=>$pathnavyHTML
        );
        
        $this->tpl();
    }
    
}