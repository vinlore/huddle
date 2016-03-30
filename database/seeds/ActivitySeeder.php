<?php

use Illuminate\Database\Seeder;

use App\Models\Activity;

class ActivitySeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){


        $attendance_application = [
            'user_id'           => rand(1,8),
            'activity_type'     => 'request',
            'source_id'         => rand(1,4),
            'source_type'       =>'conference application',
            'profile_id'        => rand(1,8)
        ];

        $attendance_application_update= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'update',
            'source_id'         => rand(1,4),
            'source_type'       =>'conference application',
            'profile_id'        => rand(1,8)
        ];

         $attendance_application_approved = [
            'user_id'           => rand(1,8),
            'activity_type'     => 'approved',
            'source_id'         => rand(1,4),
            'source_type'       =>'conference application',
            'profile_id'        => rand(1,8)
        ];

        $conference_denied= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'denied',
            'source_id'         => rand(1,4),
            'source_type'       =>'conference'
        ];

          $attendance_application_deleted= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'deleted',
            'source_id'         => rand(1,4),
            'source_type'       =>'conference application',
            'profile_id'        => rand(1,8)
        ];

         $ev_attendance_application = [
            'user_id'           => rand(1,8),
            'activity_type'     => 'request',
            'source_id'         => rand(1,6),
            'source_type'       =>'event application',
            'profile_id'        => rand(1,8)
        ];

        $event_update= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'update',
            'source_id'         => rand(1,6),
            'source_type'       =>'event'
        ];

         $ev_attendance_application_approved = [
            'user_id'           => rand(1,8),
            'activity_type'     => 'approved',
            'source_id'         => rand(1,6),
            'source_type'       =>'event application',
            'profile_id'        => rand(1,8)
        ];

        $ev_attendance_application_denied= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'denied',
            'source_id'         => rand(1,6),
            'source_type'       =>'event application',
            'profile_id'        => rand(1,8)
        ];

        $ev_deleted= [
            'user_id'           => rand(1,8),
            'activity_type'     => 'deleted',
            'source_id'         => rand(1,6),
            'source_type'       =>'event'
        ];

        $attendance_application = new Activity($attendance_application);
        $attendance_application->save();
        $attendance_application_deleted = new Activity($attendance_application_deleted);
        $attendance_application_deleted->save();
        $attendance_application_approved = new Activity($attendance_application_approved);
        $attendance_application_approved->save();
        $attendance_application_update = new Activity($attendance_application_update);
        $attendance_application_update->save();
        $conference_denied = new Activity($conference_denied);
        $conference_denied->save();
        $ev_deleted= new Activity($ev_deleted);
        $ev_deleted->save();
        $event_update = new Activity($event_update);
        $event_update->save();
        $ev_attendance_application = new Activity($ev_attendance_application);
        $ev_attendance_application->save();
        $ev_attendance_application_denied = new Activity($ev_attendance_application_denied);
        $ev_attendance_application_denied->save();
        $ev_attendance_application_approved = new Activity($ev_attendance_application_approved);
        $ev_attendance_application_approved->save();



    }
}
