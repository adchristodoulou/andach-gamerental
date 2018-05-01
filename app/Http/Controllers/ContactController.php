<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactAttachment;
use App\ContactCategory;
use App\ContactReply;
use Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('contactmiddleware')->except('create', 'store');
    }

	public function attachment($slug)
	{
		$attachment = ContactAttachment::where('slug', $slug)->first();

		$fileContent = file_get_contents('../storage/app/'.$attachment->url);

		$response = response($fileContent, 200, [
		   'Content-Type' => 'application/json',
		   'Content-Disposition' => 'attachment; filename="'.$attachment->filename.'"',
		]);

		return $response;
	}

    public function create()
    {
    	$categories = ContactCategory::pluck('name', 'id');

    	return view('contact.create', ['categories' => $categories]);
    }

    public function index()
    {
        $contacts = Contact::whereNull('closed_by')->get();

        return view('contact.index', ['contacts' => $contacts]);
    }

    public function show($id)
    {
    	$contact = Contact::find($id);
    	$replies = $contact->getOrderedBoxes();

    	return view('contact.show', ['contact' => $contact, 'replies' => $replies]);
    }

    public function store(Request $request)
    {
    	$contact = Contact::create($request->all());
        $contact->user_id = Auth::id();
    	$contact->save();

    	$contact->addAttachment($request->attachment);

        $contact->sendEmailUpdate();

        $request->session()->flash('success', 'Thankyou, we have received your comments and will be in touch shortly if needed.');

        if (Auth::check())
        {
            return redirect()->route('contact.show', $contact->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
    	$contact = Contact::find($request->id);

    	if ($request->full_text)
    	{
    		$reply = new ContactReply;
    		$reply->contact_id = $contact->id;
    		$reply->full_text = $request->full_text;
    		$reply->user_id = Auth::id();

    		if (Auth::id() == $contact->user_id)
			{
				$reply->viewed_by_initial_user_at = now();
			}

			$reply->save();

			$contact->addAttachment($request->attachment);

			$request->session()->flash('success', 'Your reply has been logged');
    	}

    	if ($request->close)
    	{
    		$contact->close();
			$request->session()->flash('success', 'This issue has been closed.');
    	}

    	return redirect()->route('contact.show', $contact->id);
    }
}
