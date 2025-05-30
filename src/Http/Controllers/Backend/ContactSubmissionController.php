<?php

namespace AcitJazz\ContactUs\Http\Controllers\Backend;

use AcitJazz\ContactUs\Http\Requests\ContactSubmissionRequest;
use Illuminate\Routing\Controller;
use Facades\AcitJazz\ContactUs\Http\Repositories\ContactSubmissionRepository;
use AcitJazz\ContactUs\Http\Resources\Frontend\ContactUsResource;
use AcitJazz\ContactUs\Models\ContactSubmission;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
 
class ContactSubmissionController extends Controller
{
 
    public function index()
    {
        $contact_submissions = ContactSubmissionRepository::paginate(20);

        return Inertia::render('contact-submission/index', [
            'contact_submissions' => ContactUsResource::collection($contact_submissions),
            'type' => type(),
            'title' => request('trash') ? 'Trash' : 'Contact Submission',
            'trash' => request('trash') ? true : false,
            'request' => request()->all(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Contact Submission',
                    'url' => route('contact-submission.index'),
                ],
            ],
        ]);
    }
    /**
     * Remove the specified resource from storage temporary.
     */
    public function delete($contact_submission)
    {
        $contact_submission = ContactSubmission::find($contact_submission);
        if (!$contact_submission) {
            return abort(404);
        }
        $contact_submission->delete();

        Cache::tags(['contact_submissions'])->flush();

        return redirect()->route('contact-submission.index')->with('message', toTitle($contact_submission->title.' hase been deleted'));
    }

    /**
     * Remove data permanently.
     */
    public function destroy($contact_submission)
    {
        $contact_submission = ContactSubmission::withTrashed()->find($contact_submission);
        if (!$contact_submission) {
            return abort(404);
        }
        $contact_submission->forceDelete();

        Cache::tags(['contact_submissions'])->flush();

        return redirect()->route('contact-submission.index')->with('message', toTitle($contact_submission->title.' hase been destroyed'));
    }

    public function destroyAll()
    {
        $ids = explode(',', request('selected'));
        $contact_submissions = ContactSubmission::whereIn('_id', $ids)->withTrashed()->get();
        foreach ($contact_submissions as $contact_submission) {
            $contact_submission->forceDelete();
        }
        Cache::tags(['contact_submissions'])->flush();

        return redirect()->route('contact-submission.index')->with('message', toTitle($contact_submission->title).' has been destroyed');
    }

    /**
     * Restore Data from trash.
     */
    public function restore($contact_submission)
    {
        $contact_submission = ContactSubmission::withTrashed()->find($contact_submission);
        if (!$contact_submission) {
            return abort(404);
        }
        $contact_submission->restore();
        Cache::tags(['contact_submissions'])->flush();

        return redirect()->route('contact-submission.index')->with('message', toTitle($contact_submission->title).' has been restored');
    }
 
}