<?php

namespace AcitJazz\ContactUs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use App\Traits\GetSet;

class ContactSubmission extends Model
{
    use SoftDeletes;
    use HasSlug;
    use GetSet;


    protected $table = 'contact_submissions';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'type',
        'files',
        'deleted_at',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('slug')
            ->saveSlugsTo('slug');
    }

    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(ContactSubmission::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
                \App\QueryFilters\Except::class,
                \App\QueryFilters\SearchName::class,
            ])
            ->thenReturn()
            ->paginate($limit)->withQueryString();
    }

    public static function allWithFilters()
    {
        return app(Pipeline::class)
            ->send(ContactSubmission::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
                \App\QueryFilters\Except::class,
                \App\QueryFilters\SearchName::class,
            ])
            ->thenReturn()
            ->get();
    }
}
