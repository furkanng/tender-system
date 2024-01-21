<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\TenderImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TenderImagesController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = "tender-image-" . rand(1, 3000) . "." . $image->getClientOriginalExtension();
                Storage::disk('public')->put('images/' . $filename, file_get_contents($image));
                (new TenderImages())->fill([
                    "tender_id" => $id,
                    "images" => $filename,
                    "url" => config("app.url") . "/storage/images/" . $filename,
                ])->saveQuietly();
            }
            return redirect()->back()->with('message', 'Resimler başarıyla yüklendi.');
        }
        return redirect()->back()->with('message', 'Yüklenecek resim bulunamadı.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = TenderImages::findOrFail($id);

        Storage::disk('public')->delete('images/' . $image->images);

        $image->delete();

        return redirect()->back()->with('message', 'Resim başarıyla silindi.');
    }
}
