<?php

namespace AcitJazz\ContactUs\Http\Controllers\Frontend;

use AcitJazz\ContactUs\Http\Requests\ContactSubmissionRequest;
use AcitJazz\ContactUs\Http\Resources\Backend\ContactSubmissionResource;
use Illuminate\Routing\Controller;
use App\Http\Resources\Frontend\PageResource;
use Facades\App\Http\Repositories\PageRepository;
use AcitJazz\ContactUs\Models\ContactSubmission;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
 
class ContactSubmissionController extends Controller
{
 
    public function index()
    {
        $page = PageRepository::findByTemplate('contact-us');
        if(is_null($page)){
            $page = [
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'content' => '',
            'meta' => [
                'title' => 'Contact Us',
                'description' => '',
                'image' => '',
            ]];
        }
        $meta = isset($page->meta) ?  checkMeta($page->meta) : $page['meta'];
        $page =  isset($page->meta) ? PageResource::make($page)->resolve() : $page;
        $contact_submission = new ContactSubmission();
        return Inertia::render('page/page-contact-us', [
            'page' => $page,
            'contact_submission' => ContactSubmissionResource::make($contact_submission)->resolve(),
         ])->withViewData([
            'meta' => $meta,
        ]);
    }
    /**
     * Remove the specified resource from storage temporary.
     */
    public function store(ContactSubmissionRequest $request)
    {
        $contact_submission = ContactSubmission::create($request->all());

        Cache::tags(['contact_submissions'])->flush();

        return redirect()->back()->with('message', 'Thank you for your submission. We will get back to you soon.');
    }
 
}