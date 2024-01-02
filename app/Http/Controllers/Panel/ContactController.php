<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactInfos = Contact::query()->first();
        
        return view('panel.pages.contact',compact('contactInfos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        $request->validate([
            "address"=>"required",
            "email"=>"required|email",
            "phone"=>"required|numeric|size:11"
        ]);
*/
        /*
        $contact = new Contact();

        $contact->address = $request->address;
        $contact->email = $request->email;
        $contact->phone = $request->phone;*/
        try {
            $contactValue = Contact::query()->first();
            $contact = Contact::updateOrCreate(
                ['id' => $contactValue->id], 
                [
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]
            );
            
            if($contact->wasRecentlyCreated){
                return redirect()->route('panel.contact.index')->with('success','Kayıt İşlemi Başarılı');
    
            }
            else{
                return redirect()->route('panel.contact.index')->with('success','Güncelleme İşlemi Başarılı');
            }
        } catch (\Throwable $th) {
            return redirect()->route('panel.contact.index')->with('error','Kayıt İşlemi Başarısız');

        }

       


        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
