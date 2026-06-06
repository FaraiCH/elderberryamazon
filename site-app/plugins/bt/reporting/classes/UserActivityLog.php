<?php

namespace Bt\Reporting\Classes;

use Bt\Reporting\Models\UserActivityLog as UserActivityLogModel;

class UserActivityLog
{
    /**
     * Create a user activity log
     * @param int $user_id the logged in user
     * @param string $type create | update | delete
     * @param string $title
     * @param string $description
     * @param array $old_data
     * @param array $new_data
     * @return UserActivityLogModel
     */
    public static function create(int $user_id, string $type = null, string $title, string $description = null, array $old_data, array $new_data): UserActivityLogModel
    {
        return UserActivityLogModel::create([
            'user_id' => $user_id,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'old_data' => json_encode($old_data),
            'new_data' => json_encode($new_data)
        ]);
    }
}
