<?php

namespace App\Http\Controllers\API;

use App\Models\Contacts;
use Illuminate\Http\Request;
use App\Services\ContactsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\ContactStoreRequest;
use App\Http\Requests\Contacts\ContactUpdateRequest;

class ContactsController extends Controller
{
    protected $contactService;

    public function __construct(ContactsService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        $contacts = $this->contactService->getContacts();

        return response()->json([
            'message' => 'Contacts Fetched Successfully',
            'contacts' => $contacts,
        ]);
    }

    public function store(ContactStoreRequest $request)
    {
        $this->contactService->storeContact($request->validated());

        return response()->json(
            [
                'status' => 200,
                'message' => 'Contact Created Successfully',
            ],
            200,
        );
    }

    public function edit($id)
    {
        $contact = Contacts::findOrFail($id);

        return response()->json(
            [
                'contact' => $contact,
                'status' => 200,
                'message' => 'Contact Fetched Successfully',
            ],
            200,
        );
    }

    public function update(ContactUpdateRequest $request, $id)
    {
        $contact = Contacts::findOrFail($id);

        $this->contactService->updateContact($contact, $request->validated());

        return response()->json(
            [
                'message' => 'Contact Updated Successfully',
                'status' => 200,
                'Contact' => $contact,
            ],
            200,
        );
    }

    public function destroy($id)
    {
        $contact = Contacts::findOrFail($id);
        $this->contactService->deleteContact($contact);

        return response()->json(
            [
                'status' => 200,
                'message' => 'Contact Deleted Successfully',
            ],
            200,
        );
    }
}
