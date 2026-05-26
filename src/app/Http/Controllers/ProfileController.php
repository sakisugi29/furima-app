<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user();
        $profile=Profile::firstOrCreate(['user_id' => $user->id]);
        $sellingItems = $user->items()->where('status', '販売中')->get();
        $purchasedItems = $user->purchases()->with('item')->get();
        $tab = $request->query('page', 'selling');
        return view('profiles.show', compact('user','profile', 'sellingItems', 'purchasedItems','tab'));
    }

    public function edit()
    {
        $profile=Profile::firstOrNew(['user_id' => auth()->id()]);
        $user=auth()->user();
        return view('profiles.edit', compact('profile','user'));
    }

    public function update(profileRequest $request)
    {
        $profile = Profile::where('user_id', auth()->id())->firstOrFail();
        $user = auth()->user();

        $user->update(['name' => $request->name]);

        $data= $request->only([ 'postal_code', 'address', 'building']);

        if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $data['profile_image'] = '/storage/' . $path;
    }

        $profile->update($data);
        return redirect('/mypage');
    }

}
