<?php

namespace App\Http\Middleware;

use App\Contact;
use App\ContactAttachment;
use Auth;
use Closure;

class ContactMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routename = $request->route()->action['as'];

        if (!Auth::check())
        {
            session()->flash('danger', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        //Also update the CheckAdmin middleware
        if (Auth::id() == 1)
        {
            return $next($request);
        }

        switch ($routename)
        {
            case 'contact.attachment' :
                $attachment = ContactAttachment::where('slug', $request->slug)->first();

                if ($attachment->contact->user_id != Auth::id())
                {
                    session()->flash('danger', 'This is not your attachment to access.');
                    return redirect()->route('home');
                }
            break;

            case 'contact.show' :
            case 'contact.update' :
                $contact = Contact::find($request->id);

                if ($contact->user_id != Auth::id())
                {
                    session()->flash('danger', 'This is not yours to access.');
                    return redirect()->route('home');
                }
            break;

            default :
                session()->flash('danger', 'Unrecognised route "'.$routename.'"'    );
                return redirect()->route('home');
            break;
        }

        return $next($request);
    }
}
