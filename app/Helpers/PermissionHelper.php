<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function translate(string $permissionName, string $model): string
    {
        $action = str_replace('_' . $model, '', $permissionName);
        
        $key = str_replace('-', '_', $action);

        $translations = [
            'view' => __('admin.global.view'),
            'create' => __('admin.global.add'),
            'edit' => __('admin.global.edit'),
            'delete' => __('admin.global.delete'),
            'force_delete' => __('admin.global.force_delete'),
            'restore' => __('admin.global.restore'),
            'view_archived' => __('admin.global.view_archived'),
            'archive' => __('admin.global.archive'),
            'promote' => __('admin.global.promote'),
            'graduate' => __('admin.global.graduate'),
        ];

        if (app()->getLocale() == 'ar') {
            return $translations[$key] ?? $action;
        } else {
            return ucwords(str_replace('_', ' ', $key));
        }
    }
}
