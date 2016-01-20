<?php
// +----------------------------------------------------------------------
// | TP-Admin [ 多功能后台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2015 http://www.hhailuo.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: XiaoYao <476552238li@gmail.com>
// +----------------------------------------------------------------------

namespace Model;
use Think\Model;

class CategoryModel extends Model {

    public function getTerms($post_type, $taxonomy_name, $siteid) {
        $taxs = $this->where(array(
            'siteid' => $siteid,
            'post_type' => $post_type,
            'taxonomy_name' => $taxonomy_name,
            ))
            ->order('arrparentid asc, listorder desc, id asc')
            ->select();
        return $taxs;
    }

    static public function wxj_category($list, $cat_id=0, $format="<option %s>%s</option>") {
        $select = "";
        foreach ($list as $key => $value) {
            $empty = "";
            for ($i=1; $i < $value[level]; $i++) {
                $empty .= '&nbsp;&nbsp;';
            }
            $select .= sprintf($format, "value='" . $value['id'] . "' " . ($cat_id == $value['id'] ? 'selected' : ''), $empty.'├─'.$value['catname']);
            if ($value['_child']) {
                $select .= CategoryModel::wxj_category($value['_child'],$cat_id);
            }
        }
        return $select;
    }
}
