<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Activity;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addActivity($userId, $activityType, $sourceId, $sourceType)
    {
        try {
            $activity = [
                'user_id'       => $userId,
                'activity_type' => $activityType,
                'source_id'     => $sourceId,
                'source_type'   => $sourceType,
            ];
            Activity::create($activity);
        } catch (Exception $e) {
            return $e;
        }
    }
}
