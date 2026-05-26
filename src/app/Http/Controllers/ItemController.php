<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;



class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab');

        $items = Item::when($search, function ($query) use ($search) {
            $query->where('item_name', 'like', "%{$search}%");
        })
        ->when($tab === 'mylist',function($query){
            $query->whereHas('likes', function($q){
                $q->where('user_id', auth()->id());
            });
        })
        ->where('user_id', '!=', auth()->id())
        ->get();

        return view('items.index', compact('items','tab'));
    }

    public function show($id){
        $item = Item::with(['likes','comments.user.profile','categories','user.profile'])->findOrFail($id);
        return view('items.show',compact('item'));
    }

    public function like($item_id){
        $item=Item::findOrFail($item_id);
        $liked=$item->likes->contains('user_id',Auth::id());

        if($liked){
            $item->likes()->where('user_id',Auth::id())->delete();
        } else{
            $item->likes()->create(['user_id'=>Auth::id()]);
        }
        return back();

        }

    public function comment(CommentRequest $request,$item_id){
        Comment::create([
            'item_id'=> $item_id,
            'user_id'=> Auth::id(),
            'comment'=> $request->validated()['comment'],
        ]);

        return back();
        }

        public function create()
{
    $categories = Category::all();
    return view('items.create', compact('categories'));
}

public function store(ExhibitionRequest $request)
{
    $item = Item::create([
        'user_id'      => auth()->id(),
        'item_name'    => $request->item_name,
        'brand_name'   => $request->brand,
        'description'  => $request->description,
        'price'        => $request->price,
        'condition'    => $request->condition,
        'status'       => '販売中',
    ]);

    if ($request->categories) {
        $item->categories()->attach($request->categories);
    }

    if ($request->hasFile('item_image')) {
        $path = $request->file('item_image')->store('item_images', 'public');
        $item->update(['item_image' => '/storage/' . $path]);
    }

    return redirect('/');
}
    }

