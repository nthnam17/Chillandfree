<?php

namespace App\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class General extends Model
{
    //
    protected $table = 'general';

    protected $fillable = ['logo', 'favicon', 'add_head', 'add_body','link_fb', 'link_ins', 'link_linked'
        ,'receive_email_contact','receive_email_recruitment', 'website', 'twitter','youtube', 'gg_maps', 'hotline'];

   
    public static function GetGeneral()
    {
        return General::all()->first();
    }

    // public static function editGeneral($current)
    // {
    //     try {
    //         $general = General::findOrFail($current->id);
    //         $general->email = $current->email;
    //         $general->phone = $current->phone;
    //         $general->website = $current->website;
    //         $general->number_config = $current->number_config;
    //         $general->logo = $current->logo;
    //         $general->logo_footer = $current->logo_footer;
    //         $general->logo_login = $current->logo_login;
    //         $general->banner_home = $current->banner_home;
    //         $general->banner_contact = $current->banner_contact;
    //         $general->img_solution = $current->img_solution;
    //         $general->img_number = $current->img_number;
    //         $general->favicon = $current->favicon;
    //         $general->add_head = $current->add_head;
    //         $general->add_body = $current->add_body;
    //         $general->link_video_impressive = $current->link_video_impressive;
    //         $general->hotline_footer = $current->hotline_footer;
    //         $general->img_job = $current->img_job;
    //         $general->img_service = $current->img_service;
    //         $general->link_fb = $current->link_fb;
    //         $general->link_ins = $current->link_ins;
    //         $general->link_linked = $current->link_linked;
    //         $general->twitter = $current->twitter;
    //         $general->youtube = $current->youtube;
    //         $general->menu_main_vi = $current->menu_main_vi;
    //         $general->menu_main_en = $current->menu_main_en;
    //         $general->menu_recruit_vi = $current->menu_recruit_vi;
    //         $general->menu_recruit_en = $current->menu_recruit_en;
    //         $general->receive_email_contact = $current->receive_email_contact;
    //         $general->receive_email_recruitment = $current->receive_email_recruitment;
    //         $general->gg_maps = $current->gg_maps;
    //         $general->slug_banner = $current->slug_banner;
    //         $general->hotline = $current->hotline;
    //         $general->save();

    //         Cache::forever('settings', $general);

    //     } catch (Exception $ex) {
    //         throw $ex;
    //     }
    // }

}
