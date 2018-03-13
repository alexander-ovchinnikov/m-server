<?php
namespace Modules\Buildings\Controllers;

use Modules\Auth\Models\ResourceSet;
use Modules\Buildings\Models\Activity;
use Modules\Buildings\Models\ActiveActivity;
use Modules\Buildings\Models\ActivityType;
use Modules\Buildings\Models\ForcePrice;
use Modules\Buildings\Models\ActivityRequirements;
use Modules\Buildings\Models\Building;
use Modules\Buildings\Models\BuildingLevel;
use Modules\Buildings\Models\BuildingType;
use Modules\Buildings\Models\GameObject;
use Modules\Auth\Models\UserResources;
use Illuminate\Database\Capsule\Manager as Capsule;


use Modules\Auth\Models\User;


#use Modules\Auth\Lib\AuthProviders\DeviceAuth;


class BuildingController {
    const E_ALREADY_EXISTS = 'User alredy Exists';
    private $authenticator;
    const DEVICE     = 1;
    const GOOGLE     = 2;
    const FACEBOOK   = 3;
    const DEFAULT_USER_NAME = "Doe";

    # /user/build/1
    public static function testTransaction() {
        Capsule::transaction( function() {
            $user =  User::where([['user_id','=',12]])->lockForUpdate()->first();
                    $user->coins+=10;
                    $user->save();
        });
        sleep(1);
        error_log('>>>');
        return [
            'id'=>User::where(['user_id'=>12])->first()->coins
        ];
    }


    public static function getPromotionPrice($secondsinput = 0) {
        $secondsinput = (int)$secondsinput;
        $conversions = ForcePrice::orderBy('value','ASC')->get()->toArray();
        if ($secondsinput <= 0) return 0;
        else if ($secondsinput === 0) $result = 0;
        else {
            $idx = 3;
            for($i=1;$i<count($conversions); $i++) {
                if ($secondsinput <= $conversions[$i]['value']) {
                    $idx = $i;
                    break;
                }
            }

            $c = $conversions;
            $gems = ceil(
                ($secondsinput + 1 - $c[$idx - 1]['value']) * ($c[$idx]['price'] - $c[$idx - 1]['price']) / ($c[$idx]['value'] - $c[$idx - 1]['value'])) + $c[$idx - 1]['price'] - 1;
        }
        return $gems;
    }


    public static function userForceActivity( $user_id, $activity_id ) {
        $activity = ActiveActivity::where([
            'id'=>$activity_id
        ])->firstOrFail();
        #$game_object = GameObject::where(['id'=>$activity->game_object_id])::firstOrFail();
        $user        = User::where(['user_id'=>$user_id])->lockForUpdate()->firstOrFail();
        $time_left = time() - $active_activity->ts_end();
        $promotion_price = self::getPromotionPrice($time_left);
        if ($user->coins >= $promotion_price ) {
            $user->coins-=$promotion_price;
            $user->save();
            $activity->ts_end = time();
            $activity->save();
        }
        return self::finishBuilding($user_id, $activity->id);
    }
    
    public static function userGetBuildings( $user_id  ) {
                    $objects = [];
                    return GameObject::where([
                                'user_id'=>$user_id
                            ])->get()->toResponse();
                    //return Building::whereIn(
                    //    'building_id',$objects)->
                    //get()->toArray();
    }

    public static function userStartActivity($user_id, $game_object_id, $activity_type_id) {
        if (null!=ActiveActivity::where([
            'game_object_id'=>$game_object_id
        ])->first()) {
            throw new \Exception('Object is busy');
        };
        $building = GameObject::where(['id'=>$game_object_id])->firstOrFail();
        $activity = Activity::join('building_activities','id','activity_id')
        ->where([
            'level_id'=>$building->level,'building_activities.type_id'=>$building->type_id
            ])->first();
        if ($activity == null) return;
        /* units manipulation */
        
        # MAYBE WE HAVE TO USE DB LCOK HERE, IF WE'RE GIVE A FUCH
        $free_user_units = UserUnits::where(['user_id'=>$user_id,'activity_id'=>0])->get()->toArray();
        if (count($free_user_units)<$activity->units_required) { 
            
        }
        $activity->units_required;

        /* end units */

        self::draftActivityResources($user_id, $activity->id);
        $active_activity = ActiveActivity::create([
                'activity_id'    => $activity->id,
                'game_object_id' => $game_object_id,
                'ts_end' => time() + $activity_time
        ]);
        return ['id'=>$active_activity->id];
    }
    public static function finishBuilding($user_id, $id ) {
            $activity = ActiveActivity::where(['game_object_id'=>$id])->firstOrFail();
            return self::finishActivity($user_id,$activity->id);
    }

    public static function finishActivity($user_id, $id ) {
        $activity = ActiveActivity::join('game_objects','game_object_id','game_objects.id')->where([
            [ 'user_id','=',$user_id    ],
            [ 'active_activities.id',    '=',$id ]
        ])->firstOrFail();

        
        $activity_base = Activity::where(['id'=>$activity->activity_id])->firstOrFail();
        $activity_id = $activity->activity_id;
        if ($resource_modifier>$activity_base->max_stack ) {
            $resource_modifier = $activity_base->max_stack;
        }
        $query= UserResources::prepareRewards($activity_id);

        $result =  $query->get(['resource_set.resource_id','resource_set.count'])->toArray();
        $query->update(['count'=>Capsule::raw('"user_resources"."count"+"resource_set"."count" * '.$resource_modifier)]);
        $activity_type = Activity::join('activity_types','type_id','activity_types.id')
            ->where(['activities.id'=>$activity->activity_id])->firstOrFail();
        if ($activity_base->max_stack>1) { //  $activity_type->name== ActivityType::REPEATABLE) {
            ActiveActivity::where(['id'=>$id])->update(['ts_end'=>time()+$activity_type->time]);
        } else {
            ActiveActivity::where(['id'=>$id])->delete();
        }

        return ['status'=>'ok'];//$result;
    }


    public static function userGetActivities($user_id) {
        return ActiveActivity::join('game_objects','game_object_id','game_objects.id')->where(['user_id'=>$user_id])->get(['activity_id','game_object_id','active_activities.id','location_id','ts_end'])->toArray(['location_id']);
    }
    
    private static function draftActivityResources($user_id, $activity_id) {
        $user_resources = []; 
        foreach(UserResources::where([
                'user_id'=>$user_id
            ])->lockForUpdate()->get() as $key => $value) {
                $user_resources[$value->resource_id] = $value;
            };

        foreach(
            ResourceSet::whereIn('id',
            array_map(
                function($item) {
                    return $item['resource_set_id'];
                },
                ActivityRequirements::where(
                    ['activity_id'=>$activity_id]
                )->get()->toArray()
            )
        )->get() as $key => &$resorce) {
            if ( $user_resources[$resorce->id]->count >= $resorce->count) {
                 $user_resources[$resorce->id]->count-=$resorce->count;
                 $user_resources[$resorce->id]->save(); 
            } else {
                 throw Exception('Not Enough Resources');
            }
        }
        return true;# ['status'=>'ok'];
    }

    private static function startBuildActivity($user_id, $level, $type_id  ) {
        #we must be in transaction here
        $activity        = Activity::where([
            'id'=> BuildingLevel::where(['level_id'=>$level,'type_id'=>$type_id])->firstOrFail()->build_activity_id
        ])->firstOrFail();

        if(self::draftActivityResources($user_id,$activity->id)) {
            return $activity;
        }
    } 

    public static function userBuildBuilding( $user_id, $type_id, $position, $flipped,$location_id=1) {
        $level = 1;
        $sort_position = 0;
        $active_activity = Capsule::transaction( function() use ($user_id, $type_id, $position, $flipped,$level,$location_id,$sort_position) {
            $activity  = static::startBuildActivity($user_id, $type_id, $level);
            $building = GameObject::create([
            //$building = Building::create([
                'location_id'=>$location_id,
                'user_id' =>$user_id,
                'type_id' =>$type_id,
                'position'=>$position,
                'sort_position'=>$sort_position,
                'level'   =>$level,
                'flipped' =>$flipped,
            ]);

            $active_activity = ActiveActivity::create(
                [
                    'activity_id'     => $activity->id,
                    'game_object_id'  => $building->id,
                    'ts_end'=>time() + $activity->time
                ]
            );
            return $active_activity;
        });
        return ['id'=>$active_activity->game_object_id];
    }


    public static function userUpgradeBuilding($user_id, $game_object_id) {
        # check if no activity
        $game_object = GameObject::where(['id'=>$game_object_id,'user_id'=>user_id])->first();
        if (null != ActiveActivity::where([
            'game_object_id'=>$game_object->id
        ])->first()) {
            throw new \Exception('Game object is busy');
        }

        $type_id = Buildings::where([
            'building_id'=>$game_object_id
        ])->first()->type_id(); 

        $activity  = Capsule::transaction(function() use ($user_id, $type_id, $level) {
              return  static::startBuildActivity($user_id, $type_id, $level);
            });

        $active_activity = ActiveActivity::create(
            [
                'activity_id'     => $activity->id,
                'game_object_id'  => $game_object_id,
                'ts_end'=>time() + $activity->time
            ]
        );

        $building = Building::where([
               'building_id'=>$game_object->id
           ])->update([
            'level'=>$level
           ]);
        return ['id'=>$active_activity->activity_id];
    }

    public static function userDestroyBuilding($user_id, $building_type_id) {
                    return Building::firstOrFail(
                        ['building_id'=>GameObject::firstOrFail(
                                [
                                    'user_id'=>$user_id,
                                    'building_id'=>$building_id
                                ]
                            )->building_id
                        ]
                    )->save();
    }
}
