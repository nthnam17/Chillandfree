<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralTranslation extends Model {

    protected $table = 'general_translations';
    protected $fillable = ['general_id', 'name', 'content', 'address', 'title','description', 'meta_title', 'meta_description', 'meta_keyword','solution_description','solution_list','solution_number',
                        'title_impressive','description_impressive','recruitment_title','recruitment_content'
                        , 'recruitment_meta_title', 'recruitment_meta_description', 'recruitment_meta_keyword', 'recruitment_slogan', 'recruitment_address'
                        , 'service_title', 'service_content', 'service_meta_title', 'service_meta_description'
                        , 'service_meta_keyword','contact_title','contact_description','about_title','about_content','about_description','footer_description_meta'
                        ,'title_services','title_achievements','title_digital','title_checkform', 'license'];

}
