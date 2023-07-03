<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public static function sections()
    {

        $getSections = Section::with('categories')->where('status',1)->get()->toArray(); // get all the section columns where status=1
        return $getSections;//with komutu ile parent elementin child elementlerini aldık sectionlar parent categoriesler isechil bu yüzden veri tabanını migrationslar ile oluşturmak çok önemlidir

    }

    public function categories(){
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>0,'status'=>1])->with('subcategories');
    }

    public static function getSection($section_id)
    {

        $section = Section::where(['status' => 1, 'id' => $section_id])->get()->first();

        if (!empty($section)) :
            return $section;
        else:
            return null;
        endif;

    }
}
