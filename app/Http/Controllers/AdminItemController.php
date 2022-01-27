<?php
namespace App\Http\Controllers;
use App\Item;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Image;

class AdminItemController extends Controller
{
    /* item creation */
    public function itemsIndex(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            $items = Item::latest()->paginate(15);
            return view('admin.item.index', compact('items'));
        } else {
            $rules = [
                'name' => Rule::unique('items', 'name')
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }
            $item = new Item();
            $item->name = $request->name;
            $item->description = $request->description;

            /* if the requst has image */
            if ($request->hasFile('image')) {
                /* if file has image */
                $image = $request->file('image');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/items')) {
                    /* if user profile folder is exits */
                    mkdir('uploads/items', 0777, true);
                }
                Image::make($image)->resize(200,200)->save('uploads/items/' . $ImageName);
                $item->image = $ImageName;
            }

            $item->save();
            return response()->json("success");
        }
    }
    /* destroy Item information*/
    public function destroyItem($id)
    {
        $item = Item::find($id);
        /* remove image */
        if (isset($item->image)) {
            $path = 'uploads/items/' . $item->image;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $item->delete();
        return redirect()->back()->with('message', 'Item Destroyed Successfully');
    }
    /* update Item details */
    public function updateItem(Request $request, $id)
    {
        $item = Item::find($id);
        if ($request->isMethod('get')) {
            /* url has get method */
            return response()->json([
                'data' => $item
            ]);
        } else {
            /* url has post method */
            $rules = [
                'edit_name' => Rule::unique('items', 'name')->ignore($id)
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                /* if the validation fails */
                return response()->json("error");
            }

            $item->name = $request->edit_name;
            $item->description = $request->edit_description;

            /* if the requst has image */
            if ($request->hasFile('edit_image')) {
                /* if file has image */
                $image = $request->file('edit_image');
                $ImageName = uniqid() . '.' . $image->getClientOriginalExtension();
                if (!file_exists('uploads/items')) {
                    /* if user profile folder is exits */
                    mkdir('uploads/items', 0777, true);
                }
                Image::make($image)->resize(520, 520)->save('uploads/items/' . $ImageName);
                $item->image = $ImageName;
            }

            $item->save();
            return response()->json("success");
        }
    }

    public function viewItem($id){
        if (request()->ajax()) {
            return datatables()->of(Products::select("products.*", "items.name as item_name")
                ->join('items', 'items.id', '=', 'products.item_id')
                ->where("item_id",$id))
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" ata-toggle="tooltip" onClick="editProduct(' . $row->id . ')" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit this Product">Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" ata-toggle="tooltip" onClick="deleteProduct(' . $row->id . ')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete this Product">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.products.index');
    }
    public function saveProduct($id,Request $request){
        Products::insert([
          "item_id"=>$id,
          "name"=>$request->name,
          "price"=>$request->price,
          "description"=>$request->description,
            "validity"=>$request->validity,
          "isSubscription"=>$request->isSubscription,
          "isActive"=>1
        ]);
    }
    public function getProduct($id){
        return json_encode(Products::where("id",$id)->first());
    }
    public function updateProduct($id, Request $request){
        Products::update([
            "item_id"=>$id,
            "name"=>$request->name,
            "price"=>$request->price,
            "description"=>$request->description,
            "validity"=>$request->validity,
            "isSubscription"=>$request->isSubscription,
            "isActive"=>1
        ])->where("id",$id);
    }
}
