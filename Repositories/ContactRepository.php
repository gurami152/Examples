<?php


namespace App\Repositories;


use App\Contact;

class ContactRepository
{
    public function all()
    {
        return Contact::all();
    }

    public function paginated($size)
    {
        $contact = Contact::paginate($size);
        foreach ($contact as $cont) {
            $cont['language_id'] = $cont->getLanguageName();
        }
        return $contact;
    }

    public function languageSelect($lang)
    {
        return Contact::where('language_id', $lang)->get();
    }
}
