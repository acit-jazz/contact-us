<?php

namespace AcitJazz\ContactUs\Http\Repositories;

use AcitJazz\ContactUs\Models\ContactSubmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ContactSubmissionRepository
{
    public const CACHE_KEY = 'CONTACT_SUBMISSIONS';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return ContactSubmission::pluck($name, $id);
        });
    }

    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return ContactSubmission::allWithFilters();
        });
    }

    public function findBySlug($slug)
    {
        $key = "findBySlug.{$slug}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($slug) {
            return ContactSubmission::findBySlug($slug);
        });
    }

    public function findByTemplate($template)
    {
        $key = "findByTemplate.{$template}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($template) {
            return ContactSubmission::where('template',$template)->latest('created_at')->first();
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return ContactSubmission::paginateWithFilters($number);
        });
    }

    public function paginateTrash($number)
    {
        request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return ContactSubmission::paginateWithFilters($number);
        });
    }

    public function countTrash()
    {
        $key = 'countTrash';
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['contact_submisions'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return ContactSubmission::onlyTrashed()->count();
        });
    }

    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY.".$key";
    }

    private function requestValue()
    {
        return http_build_query(request()->all(), '', '.');
    }
}
