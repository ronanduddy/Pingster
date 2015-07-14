<?php

App::uses('HtmlHelper', 'View/Helper');

// this helper is to give html shortcuts for the AdminLTE (css) dashboard
class SideNavHelper extends HtmlHelper {

    // 1st param: title of html link as string
    // 2nd param: css class of icon as string
    // 3rd param: url in array format eg. array('controller' => 'Users', 'action' => 'delete')
    public function LinkIcon($title, $iconClass, $url = null) {
        if ($url !== null) {
            $url = $this->url($url);
        }

        $link = '<a href="%s" title="Go to %s"><i class="%s"></i> <span>%s</span></a>';

        return sprintf($link, $url, $title, $iconClass, $title);
    }

}