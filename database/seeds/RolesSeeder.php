<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = [
            'accommodation.store'         => true,
            'accommodation.show'          => true,
            'accommodation.update'        => true,
            'accommodation.destroy'       => true,

            'conference.store'            => true,
            'conference.show'             => true,
            'conference.update'           => true,
            'conference.destroy'          => true,

            'conference_manager.store'    => true,
            'conference_manager.show'     => true,
            'conference_manager.destroy'  => true,

            'conference_attendee.show'    => true,
            'conference_attendee.update'  => true,
            'conference_attendee.destroy' => true,

            'conference_vehicle.store'    => true,
            'conference_vehicle.show'     => true,
            'conference_vehicle.update'   => true,
            'conference_vehicle.destroy'  => true,

            'event.status'                => true,
            'event.store'                 => true,
            'event.show'                  => true,
            'event.update'                => true,
            'event.destroy'               => true,

            'event_manager.store'         => true,
            'event_manager.show'          => true,
            'event_manager.destroy'       => true,

            'event_attendee.show'         => true,
            'event_attendee.update'       => true,
            'event_attendee.destroy'      => true,

            'event_vehicle.store'         => true,
            'event_vehicle.show'          => true,
            'event_vehicle.update'        => true,
            'event_vehicle.destroy'       => true,

            'item.store'                  => true,
            'item.show'                   => true,
            'item.update'                 => true,
            'item.destroy'                => true,

            'profile.store'               => true,
            'profile.show'                => true,
            'profile.update'              => true,
            'profile.destroy'             => true,

            'role.store'                  => true,
            'role.show'                   => true,
            'role.update'                 => true,
            'role.destroy'                => true,

            'room.store'                  => true,
            'room.show'                   => true,
            'room.update'                 => true,
            'room.destroy'                => true,

            'user.show'                   => true,
            'user.update'                 => true,
            'user.destroy'                => true,

            'vehicle.store'               => true,
            'vehicle.show'                => true,
            'vehicle.update'              => true,
            'vehicle.destroy'             => true,
        ];

        $conferenceManager = $superuser;
        $conferenceManager['role.store']   = false;
        $conferenceManager['role.show']    = false;
        $conferenceManager['role.update']  = false;
        $conferenceManager['role.destroy'] = false;

        $eventManager = $conferenceManager;
        $eventManager['accommodation.store']         = false;
        $eventManager['accommodation.update']        = false;
        $eventManager['accommodation.destroy']       = false;
        $eventManager['conference.store']            = false;
        $eventManager['conference.update']           = false;
        $eventManager['conference.destroy']          = false;
        $eventManager['conference_manager.store']    = false;
        $eventManager['conference_manager.destroy']  = false;
        $eventManager['conference_attendee.update']  = false;
        $eventManager['conference_attendee.destroy'] = false;
        $eventManager['conference_vehicle.store']    = false;
        $eventManager['conference_vehicle.update']   = false;
        $eventManager['conference_vehicle.destroy']  = false;
        $eventManager['item.store']                  = false;
        $eventManager['item.update']                 = false;
        $eventManager['item.destroy']                = false;
        $eventManager['room.store']                  = false;
        $eventManager['room.update']                 = false;
        $eventManager['room.destroy']                = false;

        $regularUser = [
            'accommodation.store'         => false,
            'accommodation.show'          => false,
            'accommodation.update'        => false,
            'accommodation.destroy'       => false,

            'conference.store'            => false,
            'conference.show'             => true,
            'conference.update'           => false,
            'conference.destroy'          => false,

            'conference_manager.store'    => false,
            'conference_manager.show'     => false,
            'conference_manager.destroy'  => false,

            'conference_attendee.show'    => true,
            'conference_attendee.update'  => true,
            'conference_attendee.destroy' => false,

            'conference_vehicle.store'    => false,
            'conference_vehicle.show'     => false,
            'conference_vehicle.update'   => false,
            'conference_vehicle.destroy'  => false,

            'event.store'                 => false,
            'event.show'                  => true,
            'event.update'                => false,
            'event.destroy'               => false,

            'event_manager.store'         => false,
            'event_manager.show'          => false,
            'event_manager.destroy'       => false,

            'event_attendee.show'         => true,
            'event_attendee.update'       => true,
            'event_attendee.destroy'      => false,

            'event_vehicle.store'         => false,
            'event_vehicle.show'          => false,
            'event_vehicle.update'        => false,
            'event_vehicle.destroy'       => false,

            'item.store'                  => false,
            'item.show'                   => false,
            'item.update'                 => false,
            'item.destroy'                => false,

            'profile.store'               => true,
            'profile.show'                => true,
            'profile.update'              => true,
            'profile.destroy'             => true,

            'role.store'                  => false,
            'role.show'                   => false,
            'role.update'                 => false,
            'role.destroy'                => false,

            'room.store'                  => false,
            'room.show'                   => false,
            'room.update'                 => false,
            'room.destroy'                => false,

            'user.show'                   => false,
            'user.update'                 => false,
            'user.destroy'                => false,

            'vehicle.store'               => false,
            'vehicle.show'                => false,
            'vehicle.update'              => false,
            'vehicle.destroy'             => false,
        ];

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'system administrator',
            'name'        => 'System Administrator',
            'permissions' => $superuser,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'conference manager',
            'name'        => 'Conference Manager',
            'permissions' => $conferenceManager,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'event manager',
            'name'        => 'Event Manager',
            'permissions' => $eventManager,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'regular user',
            'name'        => 'Regular User',
            'permissions' => $regularUser,
        ]);
    }
}
