<?php

namespace Bt\Production\Classes;

use Bt\Production\Models\Push as PushModel;

class Support {

    public static function getStartedTotal() {
        $unread = PushModel::where('status_id', 2)->with(
                            ['approved'=> function ($query) {
                                     $query->where('status_id',1);
                                    }]
                                    )->where('created_at','>','2022-03-01 00:00:00')->count();

        return ($unread > 0) ? $unread : null;
    }

}

?>