<?php
/**
 * @author Admiko
 * @copyright Copyright (c) Admiko
 * @link https://admiko.com
 * @Help We are committed to delivering the best code quality and user experience. If you have suggestions or find any issues, please don't hesitate to contact us. Thank you.
 * This file is managed by Admiko and is not recommended to be modified.
 * Any custom code should be added elsewhere to avoid losing changes during updates.
 * However, in case your code is overwritten, you can always restore it from a backup folder.
 */

namespace App\Models\Admin\AdminService\Auth\AuthUser;

class AuthUserExtended extends AuthUser
{
    public function roles()
    {
        return $this->belongsToMany('App\Models\Admin\AdminRoles\AdminRoles')->withPivot('role_id');
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles);
        }
        return $this->hasRole($roles);
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('title', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('title', $role)->first();
    }
}
