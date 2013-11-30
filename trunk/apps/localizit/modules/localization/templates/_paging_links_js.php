<?php

echo "<ul class=\"paging $location\">";
echo "<li class=\"desc\">".__($pager->getFirstIndice() . '-' . $pager->getLastIndice() . ' ' . __('of') . ' ' . $pager->getNumResults())."</li> ";
echo "<li class=\"first\"><a href=\"javascript:submitPage(1)\" class=\"tiptip\" title=\"".__('First')."\">".__('First')."</a></li> ";
echo "<li class=\"previous\"><a href=\"javascript:submitPage({$pager->getPreviousPage()})\" class=\"tiptip\" title=\"".__('Previous')."\">".__('Previous')."</a></li> ";

foreach ($pager->getLinks() as $page):

    if ($page == $pager->getPage()) {
        echo "<li><a class=\"current\" href=\"#\">$page</a></li> ";
    } else {
        echo "<li><a href=\"javascript:submitPage($page)\">$page</a></li> ";
    }
    
endforeach;

echo "<li class=\"next\"><a href=\"javascript:submitPage({$pager->getNextPage()})\" class=\"tiptip\" title=\"".__('Next')."\">".__('Next')."</a></li> ";
echo "<li class=\"last\"><a href=\"javascript:submitPage({$pager->getLastPage()})\" class=\"tiptip\" title=\"".__('Last')."\">".__('Last')."</a></li>";
echo "</ul>";