<?php

namespace App\Classes\Theme;

use App\Models\MenuManager;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class Menu
{

  public static function sidebar()
  {
    $menuManager = new MenuManager;
    $roleId = isset(Auth::user()->roles[0]) ? Auth::user()->roles[0]->id : NULL;
    $menu_list = $menuManager->getall($roleId);
    $roots = $menu_list->where('parent_id', 0) ?? array();
    return self::tree($roots, $menu_list, $roleId);
  }

  public static function theme()
  {
    $theme = Theme::select('direction', 'sidebar_layout', 'sidemenu', 'theme_layout', 'sidebar_color')->where('user_id', Auth::id())->first() ?? NULL;
    $value = array_values((isset($theme) ? $theme->toArray() : array()));
    return implode(" ", $value);
  }


  public static function tree($roots, $menu_list, $roleId, $parentId = 0)
  {

    $html = $parentId != 0 ? '<ul class="sidebar-menu" data-widget="tree">' : '<ul class="sidebar-menu" data-widget="tree">';
    $segment ='/'.request()->segment(1). '/' .request()->segment(2);
    foreach ($roots as $item) {
      $find = $menu_list->where('parent_id', $item['id']);
      $html .= '
      <li class="'.($find->count() > 0  ? "treeview" : '').'  '.(isset($item->menupermission->path_url)  ?  ($segment == $item->menupermission->path_url) ? 'active' : '' : '').' ">
      <a href ="'.(!$item->menu_permission_id ? ($item->path_url ? $item->path_url : '#') : $item->menupermission->path_url).'">
         <i class="' . (!$item->menu_permission_id ? $item->icon : $item->menupermission->icon) . ' "style="color:rgb(60, 179, 113);"></i>
          <span>'. (!$item->menu_permission_id ? $item->title : $item->menupermission->title) . '</span>
          <span class="pull-right-container">'.($find->count() > 0 ? "  <i class='fa fa-angle-right pull-right'></i>" : '').'</span>
      </a>
      ';
      if ($find->count()) {
        $html .= self::children($find, $menu_list, $roleId, $item['id']);
      }
      $html .= '</li>';
      $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;

  }


  public static function children($roots, $menu_list, $roleId, $parentId = 0){
    $segment ='/'.request()->segment(1). '/' .request()->segment(2);
    foreach ($roots as $item) {
        $active = (isset($item->menupermission->path_url)  ?  ($segment == $item->menupermission->path_url) ? 'block' : 'open' : '');
        $html = '<ul class="treeview-menu" style="display:'.$active.';">';
    }


    foreach ($roots as $item) {
      $find = $menu_list->where('parent_id', $item['id']);
      if ($find->count() > 0) {
        $htmlChildren = self::children($find, $menu_list, $roleId, $item['id']);
        $active = (isset($item->menupermission->path_url)  ?  ($segment == $item->menupermission->path_url) ? 'active' : '' : '');
        $html .= '
        <li class="'.$active.'">
            <a href="'.(!$item->menu_permission_id ? ($item->path_url ? $item->path_url : '#') : $item->menupermission->path_url).'">
              <i class="' . (!$item->menu_permission_id ? $item->icon : $item->menupermission->icon) . '" >
              <span class="path1"></span>
              <span class="path2"></span>
              </i>
                ' . (!$item->menu_permission_id ? $item->title : $item->menupermission->title) . '
            </a>
            '.$htmlChildren.'
        </li>';
      }else{
        $html .= '
        <li class="'.(isset($item->menupermission->path_url)  ?  ($segment == $item->menupermission->path_url) ? 'active' : '' : '').'">
            <a href="'.(!$item->menu_permission_id ? ($item->path_url ? $item->path_url : '#') : $item->menupermission->path_url).'">
            <i class="' . (!$item->menu_permission_id ? $item->icon : $item->menupermission->icon) . '"  >
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
                ' . (!$item->menu_permission_id ? $item->title : $item->menupermission->title) . '
            </a>
        </li>';
      }
    }
    $html .= '</ul>';
    return $html;
  }
}
