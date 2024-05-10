<?php

namespace App\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class General extends Model
{
    use Translatable;
    //
    protected $table = 'general';

    protected $fillable = ['logo', 'favicon', 'add_head', 'add_body', 'img_solution', 'banner_home', 'img_number', 'link_video_impressive', 'hotline_footer', 'img_job'
        , 'img_service', 'link_fb', 'link_ins', 'link_linked', 'menu_main_vi', 'menu_main_en', 'menu_recruit_vi', 'menu_recruit_en', 'receive_email_contact',
        'receive_email_recruitment', 'img_amount', 'logo_footer', 'number_config', 'logo_login', 'solution_checkbox', 'website', 'banner_contact', 'twitter',
        'youtube', 'gg_maps', 'slug_banner', 'hotline'];

    public $translatedAttributes = ['name', 'content', 'address', 'title', 'description', 'meta_title', 'meta_description', 'meta_keyword', 'solution_description', 'title_impressive',
        'solution_list', 'solution_number', 'description_impressive', 'title_contact_home', 'evaluate_title', 'evaluate_description'
        , 'recruitment_title', 'recruitment_content', 'recruitment_meta_title', 'recruitment_meta_description', 'recruitment_meta_keyword', 'recruitment_address'
        , 'recruitment_slogan', 'service_title', 'service_content', 'service_meta_title', 'service_meta_description'
        , 'service_meta_keyword', 'footer_description', 'contact_title', 'contact_description', 'about_title', 'about_content', 'about_description', 'copyright_title', 'license'];

    public static function GetGeneral()
    {
        return General::all()->first();
    }

    public static function editGeneral($current)
    {
        try {
            $general = General::findOrFail($current->id);
            $general->email = $current->email;
            $general->phone = $current->phone;
            $general->website = $current->website;
            $general->number_config = $current->number_config;
            $general->logo = $current->logo;
            $general->logo_footer = $current->logo_footer;
            $general->logo_login = $current->logo_login;
            $general->banner_home = $current->banner_home;
            $general->banner_contact = $current->banner_contact;
            $general->img_solution = $current->img_solution;
            $general->img_number = $current->img_number;
            $general->favicon = $current->favicon;
            $general->add_head = $current->add_head;
            $general->add_body = $current->add_body;
            $general->link_video_impressive = $current->link_video_impressive;
            $general->hotline_footer = $current->hotline_footer;
            $general->img_job = $current->img_job;
            $general->img_service = $current->img_service;
            $general->link_fb = $current->link_fb;
            $general->link_ins = $current->link_ins;
            $general->link_linked = $current->link_linked;
            $general->twitter = $current->twitter;
            $general->youtube = $current->youtube;
            $general->menu_main_vi = $current->menu_main_vi;
            $general->menu_main_en = $current->menu_main_en;
            $general->menu_recruit_vi = $current->menu_recruit_vi;
            $general->menu_recruit_en = $current->menu_recruit_en;
            $general->receive_email_contact = $current->receive_email_contact;
            $general->receive_email_recruitment = $current->receive_email_recruitment;
            $general->gg_maps = $current->gg_maps;
            $general->slug_banner = $current->slug_banner;
            $general->hotline = $current->hotline;

            $general->translate('vi')->name = $current->name_vi;
            $general->translate('vi')->address = $current->address_vi;
            $general->translate('vi')->description = $current->description_vi;
            $general->translate('vi')->content = $current->content_vi;
            $general->translate('vi')->title = $current->title_vi;
            $general->translate('vi')->meta_title = $current->meta_title_vi;
            $general->translate('vi')->meta_description = $current->meta_description_vi;
            $general->translate('vi')->meta_keyword = $current->meta_keyword_vi;
            $general->translate('vi')->solution_description = $current->solution_description_vi;
            $general->translate('vi')->solution_list = $current->gallery_vi;
            $general->translate('vi')->solution_number = $current->solutionNumber_vi;
            $general->translate('vi')->title_impressive = $current->title_impressive_vi;
            $general->translate('vi')->description_impressive = $current->description_impressive_vi;
            $general->translate('vi')->title_contact_home = $current->title_contact_home_vi;
            $general->translate('vi')->evaluate_title = $current->evaluate_title_vi;
            $general->translate('vi')->evaluate_description = $current->evaluate_description_vi;
            $general->translate('vi')->about_title = $current->about_title_vi;
            $general->translate('vi')->about_description = $current->about_description_vi;
            $general->translate('vi')->about_content = $current->about_content_vi;
            $general->translate('vi')->contact_title = $current->contact_title_vi;
            $general->translate('vi')->contact_description = $current->contact_description_vi;
            $general->translate('vi')->copyright_title = $current->copyright_title_vi;


            $general->translate('vi')->recruitment_title = $current->recruitment_title_vi;
            $general->translate('vi')->recruitment_content = $current->recruitment_content_vi;
            $general->translate('vi')->recruitment_meta_title = $current->recruitment_meta_title_vi;
            $general->translate('vi')->recruitment_meta_description = $current->recruitment_meta_description_vi;
            $general->translate('vi')->recruitment_meta_keyword = $current->recruitment_meta_keyword_vi;
            $general->translate('vi')->recruitment_slogan = $current->recruitment_slogan_vi;
            $general->translate('vi')->recruitment_address = $current->recruitment_address_vi;

            $general->translate('vi')->service_title = $current->service_title_vi;
            $general->translate('vi')->service_content = $current->service_content_vi;
            $general->translate('vi')->service_meta_title = $current->service_meta_title_vi;
            $general->translate('vi')->service_meta_description = $current->service_meta_description_vi;
            $general->translate('vi')->service_meta_keyword = $current->service_meta_keyword_vi;
            $general->translate('vi')->footer_description = $current->footer_description_vi;
            $general->translate('vi')->footer_description_meta = $current->footer_description_meta_vi;
            $general->translate('vi')->title_services = $current->title_services_vi;
            $general->translate('vi')->title_achievements = $current->title_achievements_vi;
            $general->translate('vi')->title_digital = $current->title_digital_vi;
            $general->translate('vi')->title_checkform = $current->title_checkform_vi;
            $general->translate('vi')->license = $current->license_vi;

            $general->translate('en')->name = $current->name_en;
            $general->translate('en')->address = $current->address_en;
            $general->translate('en')->description = $current->description_en;
            $general->translate('en')->content = $current->content_en;
            $general->translate('en')->title = $current->title_en;
            $general->translate('en')->meta_title = $current->meta_title_en;
            $general->translate('en')->meta_description = $current->meta_description_en;
            $general->translate('en')->meta_keyword = $current->meta_keyword_en;
            $general->translate('en')->title_impressive = $current->title_impressive_en;
            $general->translate('en')->solution_description = $current->solution_description_en;
            $general->translate('en')->solution_list = $current->gallery_en;
            $general->translate('en')->solution_number = $current->solutionNumber_en;
            $general->translate('en')->title_impressive = $current->title_impressive_en;
            $general->translate('en')->description_impressive = $current->description_impressive_en;
            $general->translate('en')->title_contact_home = $current->title_contact_home_en;
            $general->translate('en')->evaluate_title = $current->evaluate_title_en;
            $general->translate('en')->evaluate_description = $current->evaluate_description_en;

            $general->translate('en')->about_title = $current->about_title_en;
            $general->translate('en')->about_description = $current->about_description_en;
            $general->translate('en')->about_content = $current->about_content_en;
            $general->translate('en')->contact_title = $current->contact_title_en;
            $general->translate('en')->contact_description = $current->contact_description_en;
            $general->translate('en')->copyright_title = $current->copyright_title_en;

            $general->translate('en')->recruitment_title = $current->recruitment_title_en;
            $general->translate('en')->recruitment_content = $current->recruitment_content_en;
            $general->translate('en')->recruitment_meta_title = $current->recruitment_meta_title_en;
            $general->translate('en')->recruitment_meta_description = $current->recruitment_meta_description_en;
            $general->translate('en')->recruitment_meta_keyword = $current->recruitment_meta_keyword_en;
            $general->translate('en')->recruitment_slogan = $current->recruitment_slogan_en;
            $general->translate('en')->recruitment_address = $current->recruitment_address_en;
            $general->translate('en')->license = $current->license_en;

            $general->translate('en')->service_title = $current->service_title_en;
            $general->translate('en')->service_content = $current->service_content_en;
            $general->translate('en')->service_meta_title = $current->service_meta_title_en;
            $general->translate('en')->service_meta_description = $current->service_meta_description_en;
            $general->translate('en')->service_meta_keyword = $current->service_meta_keyword_en;
            $general->translate('en')->footer_description = $current->footer_description_en;
            $general->translate('en')->footer_description_meta = $current->footer_description_meta_en;
            $general->translate('en')->title_services = $current->title_services_en;
            $general->translate('en')->title_achievements = $current->title_achievements_en;
            $general->translate('en')->title_digital = $current->title_digital_en;
            $general->translate('en')->title_checkform = $current->title_checkform_en;

            $general->save();

            Cache::forever('settings', $general);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function editProfile($profile)
    {
        try {
            $user = User::find($profile->id);
            $user->name = $profile->name;
            $user->username = $profile->username;
            $user->email = $profile->email;
            if (!is_null($profile->password)) {
                $user->password = bcrypt($profile->password);
            }

            $user->save();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
