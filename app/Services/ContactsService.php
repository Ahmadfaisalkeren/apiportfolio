<?php

namespace App\Services;

use App\Models\Contacts;
use Illuminate\Support\Facades\Storage;

/**
 * Class ContactsService.
 */
class ContactsService
{
    public function getContacts()
    {
        $contacts = Contacts::all();

        return $contacts;
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/contacts', $imageName, 'public');

        return $imagePath;
    }

    public function storeContact(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->storeImage($data['image']);
        }
        Contacts::create($data);
    }

    public function getContactById($id)
    {
        $contact = Contacts::findOrFail($id);

        return $contact;
    }

    private function updateImage(Contacts $contact, $image = null)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/contacts', $imageName);

            if ($contact->image) {
                Storage::delete('public/' . $contact->image);
            }

            $contact->image = str_replace('public/', '', $imagePath);
        }
    }

    public function updateContact(Contacts $contact, array $data)
    {
        $contact->title = $data['title'] ?? $contact->title;
        $contact->link = $data['link'] ?? $contact->link;

        $this->updateImage($contact, $data['image'] ?? null);

        $contact->save();

        return $contact;
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }

    public function deleteContact(Contacts $contact)
    {
        $this->deleteImage($contact->image);

        $contact->delete();
    }
}
