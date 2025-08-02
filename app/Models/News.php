<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class News extends Model
{
    use HasFactory;
    use HasRichText;

    protected $table = 'm_news';
    protected $primaryKey = 'news_id';

    protected $guarded = [];

    protected $richTextAttributes = [
        'content'
    ];
}
