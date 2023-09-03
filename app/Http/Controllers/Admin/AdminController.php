<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use DateTime;
use Exception;

class AdminController extends Controller
{
    public function index(){
        return view('user.userpage');
    }

    public function redirect(){
        $usertype = Auth::user()->usertype;
        if ($usertype == '1'){
            return view('admin.dashboard');
        }
        else{
            return view('user.userpage');
        }
    }

    public function view_category(){
        return view('admin.add_category');
    }

    public function fetch_category(Request $request){
        // $cat_details = category::all();
        // if($cat_details)
        // {
        //     return response()->json([
        //         'cat_details'=>$cat_details,
        //     ]);
        // }
        // else
        // {
        //     return response()->json([
        //         'status'=>404,
        //         'message'=>'No Category Found.'
        //     ]);
        // }

        $draw = $request->get('draw'); // Internal use
        $start = $request->get("start"); // where to start next records for pagination
        $rowPerPage = $request->get("length"); // How many recods needed per page for pagination
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); // It will give us columns array
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];  // This will let us know,which column index should be sorted
        $columnName = $columnNameArray[$columnIndex]['data']; // Here we will get column name,Base on the index we get
        $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue = $searchArray['value']; // This is search value

        $cats = category::query();
        $total = $cats->count();

        $totalFilter = category::query();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('category_name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = category::query();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('category_name','like','%'.$searchValue.'%');
        }

        $arrData = $arrData->get();

        $category_arr = array();
            $i = 1;
            foreach ($arrData as $record) {
                $sl_no = $start + $i++;
                $category = $record->category_name;
                $action = '<button type="button" value="'.$record->id.'" class="badge badge-outline-danger btn-sm" id="deletebtn">Delete</button>';

                $category_arr[] = array(
                    "id" => $sl_no,
                    "category_name" => $category,
                    "action" => $action
                );
            }

            if ($arrData->count() > 1000) {
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $total,
                    "recordsFiltered" => $totalFilter,
                    "data" => $category_arr,
                    "length" => 1
                );
            } else {
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $total,
                    "recordsFiltered" => $totalFilter,
                    "data" => $category_arr,
                    "length" => 0
                );
            }

        return response()->json($response);
    }

    public function add_category(Request $request){

        $validator = Validator::make($request->all(), [
            'category'=> 'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $exist = category::where('category_name', $request->input('category'))->exists();
            if($exist){
                return response()->json([
                    'status'=>400,
                    'message'=>'Category Already Exist.'
                ]);
            } else {
                $cat_data = new category;
                $cat_data->category_name = $request->input('category');
                $cat_data->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Added Successfully.'
                ]);
            }
        }

        // $data = new category;
        // $data->category_name = $request->category;
        // $data->save();
        // return redirect()->back()->with('message', 'Category Added Successfully');
    }

    public function delete_category($id){

        $del_cat_data = category::find($id);
        if($del_cat_data)
        {
            $del_cat_data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Category Found.'
            ]);
        }
    }

    public function view_product(){
        $category_data = category::all();
        return view('admin.add_Product',compact('category_data'));
    }

    public function show_product(){
        return view('admin.show_product');
    }

    public function fetch_product(Request $request){
        $draw = $request->get('draw'); // Internal use
        $start = $request->get("start"); // where to start next records for pagination
        $rowPerPage = $request->get("length"); // How many recods needed per page for pagination
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); // It will give us columns array
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];  // This will let us know,which column index should be sorted
        $columnName = $columnNameArray[$columnIndex]['data']; // Here we will get column name,Base on the index we get
        $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue = $searchArray['value']; // This is search value

        $users = Product::query();
        $total = $users->count();

        $totalFilter = Product::query();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('title','like','%'.$searchValue.'%');
            $totalFilter = $totalFilter->orWhere('description','like','%'.$searchValue.'%');
            $totalFilter = $totalFilter->orWhere('quantity','like','%'.$searchValue.'%');
            $totalFilter = $totalFilter->orWhere('category','like','%'.$searchValue.'%');
            $totalFilter = $totalFilter->orWhere('price','like','%'.$searchValue.'%');
            $totalFilter = $totalFilter->orWhere('discount_price','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = Product::query();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('title','like','%'.$searchValue.'%');
            $arrData = $arrData->orWhere('description','like','%'.$searchValue.'%');
            $arrData = $arrData->orWhere('quantity','like','%'.$searchValue.'%');
            $arrData = $arrData->orWhere('category','like','%'.$searchValue.'%');
            $arrData = $arrData->orWhere('price','like','%'.$searchValue.'%');
            $arrData = $arrData->orWhere('discount_price','like','%'.$searchValue.'%');
        }

        $arrData = $arrData->get();

        $product_arr = array();
            $i = 1;
            foreach ($arrData as $record) {
                $status = $record->is_active == 'Y' ? 'checked' : '';
                $sl_no = $start + $i++;
                $title = $record->title;
                if (strlen($record->description) > 20) {
                    $description = substr($record->description, 0, 20). "...";
                } else{
                    $description = $record->description;
                }
                $quantity = $record->quantity;
                $category = $record->category;
                $price = $record->price;
                $discount_price = '-';
                if(!empty($record->discount_price)){
                    $discount_price = $record->discount_price;
                }
                $image = '<img src="/product-Image/'.$record->image.'" style="width: 50px;height: 50px;border-radius: 10%;margin: auto;" alt="image"/>';
                $action = '<button type="button" value="'.$record->id.'" class="badge badge-outline-success editbtn mr-1" data-bs-toggle="offcanvas" data-bs-target="#sidebardemo">Edit</button> <button type="button" value="'.$record->id.'" class="badge badge-outline-danger deletebtn mr-1">Delete</button> <label class="switch label0"><input type="checkbox" class="is_active isactive" '.$status.' data-prod_auto_id="'.$record->id.'"><span class="slider round"></span></label>';

                $product_arr[] = array(
                    "id" => $sl_no,
                    "title" => $title,
                    "description" => $description,
                    "quantity" => $quantity,
                    "category" => $category,
                    "price" => $price,
                    "discount_price" => $discount_price,
                    "image" => $image,
                    "action" => $action
                );
            }

            if ($arrData->count() > 1000) {
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $total,
                    "recordsFiltered" => $totalFilter,
                    "data" => $product_arr,
                    "length" => 1
                );
            } else {
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $total,
                    "recordsFiltered" => $totalFilter,
                    "data" => $product_arr,
                    "length" => 0
                );
            }

        return response()->json($response);
    }

    public function create_product(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=> 'required|max:191',
            'description'=> 'required|max:191',
            'price'=> 'required|max:191',
            'quantity'=> 'required|max:191',
            'category'=> 'required|max:191',
            // 'image'=> 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $product_data = new product;
            $product_data->title = $request->title;
            $product_data->description = $request->description;
            $product_data->price = $request->price;
            $product_data->quantity = $request->quantity;
            $product_data->discount_price = $request->dis_price;
            $product_data->category = $request->category;
            $imagename = time().'.'.$request->image[0]->getClientOriginalExtension();
            $directory = 'product-Image';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $request->image[0]->move(public_path($directory), $imagename);
            $product_data->image = $imagename;
            $product_data->save();
            return response()->json([
                'status'=>200,
                'message'=>'Product Added Successfully.'
            ]);
        }
    }

    public function edit_product($id)
    {
        $product = product::find($id);
        $category = category::all();
        if($product)
        {
            return response()->json([
                'status'=>200,
                'prod_details'=> $product,
                'prod_category'=> $category,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Student Found.'
            ]);
        }

    }

    public function update_product(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'update_title'=> 'required|max:191',
            'update_description'=> 'required|max:191',
            'update_price'=> 'required|max:191',
            'update_quantity'=> 'required|max:191',
            'update_category'=> 'required|max:191',
            'update_image'=> 'mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $upd_prod = product::find($id);
            if($upd_prod)
            {
                // print_r($request->all());die;
                $upd_prod->title = $request->update_title;
                $upd_prod->description = $request->update_description;
                $upd_prod->price = $request->update_price;
                $upd_prod->quantity = $request->update_quantity;
                $upd_prod->discount_price = $request->update_dis_price;
                $upd_prod->category = $request->update_category;
                $image = $request->update_image;
                $pre_img = $request->old_pic;
                if(count($request->all()) > 8)
                {
                    $imagename = time().'.'.$image->getClientOriginalExtension();
                    $request->update_image->move('product-Image',$imagename);
                    $upd_prod->image = $imagename;
                    // Using unlink() function to delete old file
                    $unlink_path = 'product-Image/' .$pre_img;
                    unlink($unlink_path);
                }
                else{
                    $upd_prod->image = $pre_img;
                }
                $upd_prod->update();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Product Updated Successfully.'
                    ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Found.'
                ]);
            }

        }
    }

    public function delete_product($id){
        $del_prod_data = product::find($id);
        $del_prod_img = DB::table('products')->select('image')->where('id', $id)->get()->toArray();
        if($del_prod_data)
        {
            $unlink_path = 'product-Image/' .$del_prod_img[0]->image;
            unlink($unlink_path);
            $del_prod_data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Product Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Product Found.'
            ]);
        }
    }

    public function product_status(Request $request, $id){
        $upd_prod_status = product::find($id);
            if($upd_prod_status)
            {
                // print_r($request->all());die;
                $upd_prod_status->is_active = $request->prod_status;
                $upd_prod_status->update();
                if($request->prod_status == 'Y'){
                    return response()->json([
                        'status'=>200,
                        'message'=>'Product actived.'
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>400,
                        'message'=>'Product Inactived.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'No Product Found.'
                ]);
            }
    }

    public function show_order(){
        return view('admin.order');
    }

    public function fetch_Order(Request $request){
        try {
            $draw = $request->get('draw'); // Internal use
            $start = $request->get("start"); // where to start next records for pagination
            $rowPerPage = $request->get("length"); // How many recods needed per page for pagination
            $orderArray = $request->get('order');
            $columnNameArray = $request->get('columns'); // It will give us columns array
            $searchArray = $request->get('search');
            $columnIndex = $orderArray[0]['column'];  // This will let us know,which column index should be sorted
            $columnName = $columnNameArray[$columnIndex]['data']; // Here we will get column name,Base on the index we get
            $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
            $searchValue = $searchArray['value']; // This is search value

            switch ($columnName) {
                case 'id':
                case 'product_qty':
                case 'product_prc':
                case 'bill_name':
                case 'bill_Phone':
                case 'bill_email':
                case 'country':
                case 'state':
                case 'city':
                case 'address1':
                case 'address2':
                case 'pin_code':
                case 'payment_mode':
                case 'payment_id':
                case 'order_status':
                case 'tracking_no':
                case 'created_at':
                    $orderTable = 'orders.';
                    break;

                case 'user_name':
                    $orderTable = 'users.';
                    $columnName = 'name';
                    break;

                case 'product_title':
                    $orderTable = 'products.';
                    $columnName = 'title';
                    break;

                default:
                    $orderTable = '';
            }

            // $orders = Order::query();
            // $total = $orders->count();

            $total = Order::select('count(*) as allcount')->count();
            $totalFilter = Order::select('count(*) as allcount')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->where(function ($p) use ($searchValue) {
                    $p->orWhere('orders.product_qty', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.product_prc', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.bill_name', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.bill_Phone', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.bill_email', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.country', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.state', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.city', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.address1', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.address2', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.pin_code', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.payment_mode', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.payment_id', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.order_status', 'like', '%' . $searchValue . '%')
                        ->orWhere('orders.tracking_no', 'like', '%' . $searchValue . '%')
                        ->orWhere(DB::raw('DATE_FORMAT(orders.created_at, "%m/%d/%Y")'), "like", '%' . $searchValue . '%')
                        ->orWhere(DB::raw('users.name'), 'like', '%' . $searchValue . '%')
                        ->orWhere(DB::raw('products.title'), 'like', '%' . $searchValue . '%');

                })
                ->count();

            // $totalFilter = Order::query();
            // if (!empty($searchValue)) {
            //     $totalFilter = $totalFilter->where('title','like','%'.$searchValue.'%');
            //     $totalFilter = $totalFilter->orWhere('description','like','%'.$searchValue.'%');
            //     $totalFilter = $totalFilter->orWhere('quantity','like','%'.$searchValue.'%');
            //     $totalFilter = $totalFilter->orWhere('category','like','%'.$searchValue.'%');
            //     $totalFilter = $totalFilter->orWhere('price','like','%'.$searchValue.'%');
            //     $totalFilter = $totalFilter->orWhere('discount_price','like','%'.$searchValue.'%');
            // }
            // $totalFilter = $totalFilter->count();

            $arrData = Order::select(
                'orders.product_qty',
                'orders.product_prc',
                'orders.bill_name',
                'orders.bill_phone',
                'orders.bill_email',
                'orders.country',
                'orders.state',
                'orders.city',
                'orders.address1',
                'orders.address2',
                'orders.pin_code',
                'orders.payment_mode',
                'orders.payment_id',
                'orders.order_status',
                'orders.tracking_no',
                'orders.created_at',
                'users.name',
                'products.title',
            )
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->where(function ($p) use ($searchValue) {
                $p->orWhere('orders.product_qty', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.product_prc', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.bill_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.bill_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.bill_email', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.country', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.state', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.city', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.address1', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.address2', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.pin_code', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.payment_mode', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.payment_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.order_status', 'like', '%' . $searchValue . '%')
                    ->orWhere('orders.tracking_no', 'like', '%' . $searchValue . '%')
                    ->orWhere(DB::raw('DATE_FORMAT(orders.created_at, "%m/%d/%Y")'), "like", '%' . $searchValue . '%')
                    ->orWhere(DB::raw('users.name'), 'like', '%' . $searchValue . '%')
                    ->orWhere(DB::raw('products.title'), 'like', '%' . $searchValue . '%');

            })
            ->orderBy($orderTable . $columnName, $columnSortOrder)->skip($start)->take($rowPerPage)->get();

            // return $arrData;

            // $arrData = Order::query();
            // $arrData = $arrData->skip($start)->take($rowPerPage);
            // $arrData = $arrData->orderBy($columnName,$columnSortOrder);

            // if (!empty($searchValue)) {
            //     $arrData = $arrData->where('title','like','%'.$searchValue.'%');
            //     $arrData = $arrData->orWhere('description','like','%'.$searchValue.'%');
            //     $arrData = $arrData->orWhere('quantity','like','%'.$searchValue.'%');
            //     $arrData = $arrData->orWhere('category','like','%'.$searchValue.'%');
            //     $arrData = $arrData->orWhere('price','like','%'.$searchValue.'%');
            //     $arrData = $arrData->orWhere('discount_price','like','%'.$searchValue.'%');
            // }

            // $arrData = $arrData->get();

            $order_arr = array();
                $i = 1;
                foreach ($arrData as $record) {
                    // $status = $record->is_active == 'Y' ? 'checked' : '';
                    $sl_no = $start + $i++;
                    $product_qty = $record->product_qty;
                    $product_prc = $record->product_prc;
                    $name = $record->bill_name;
                    $phone = $record->bill_phone;
                    $email = $record->bill_email;
                    $country = $record->country;
                    $state = $record->state;
                    $city = $record->city;
                    $address1 = $record->address1;
                    $address2 = $record->address2;
                    $pin_code = $record->pin_code;
                    $payment_mode = $record->payment_mode;
                    $payment_id = $record->payment_id;
                    $order_status = $record->order_status;
                    $tracking_no = $record->tracking_no;
                    $dateString = $record->created_at;
                    // $dateString = '2023-02-27T15:27:17.000000Z';
                    $date = new DateTime($dateString);
                    $created_at = $date->format('d/m/Y');
                    $user_name = $record->name;
                    $product_title = $record->title;
                    $action = ' <button type="button" class="btn btn-outline-danger mb-2">Delete</button><br>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline-warning dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Status</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>Pending
                                            <label class="form-check-label" for="radio1"></label>
                                        </div><hr>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2" checked>Confirmed
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio3" name="optradio" value="option3">Shipped
                                            <label class="form-check-label" for="radio3"></label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio4" name="optradio" value="option4">Out For Delivery
                                            <label class="form-check-label" for="radio4"></label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio5" name="optradio" value="option5">Delivered
                                            <label class="form-check-label" for="radio5"></label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="radio" class="form-check-input" id="radio6" name="optradio" value="option6">Cancel
                                            <label class="form-check-label" for="radio6"></label>
                                        </div>
                                    </div>
                                </div> ';
                            // <div class="dropdown">
                            //   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            //     Dropdown button
                            //   </button>
                            //   <div class="dropdown-menu" >
                            //     <a class="dropdown-item" href="#">Action</a>
                            //     <a class="dropdown-item" href="#">Another action</a>
                            //     <a class="dropdown-item" href="#">Something else here</a>
                            //   </div>
                            // </div>

                    $order_arr[] = array(
                        "id" => $sl_no,
                        "product_qty" => $product_qty,
                        "product_prc" => $product_prc,
                        "bill_name" => $name,
                        "bill_phone" => $phone,
                        "bill_email" => $email,
                        "country" => $country,
                        "state" => $state,
                        "city" => $city,
                        "address1" => $address1,
                        "address2" => $address2,
                        "pin_code" => $pin_code,
                        "payment_mode" => $payment_mode,
                        "payment_id" => $payment_id,
                        "order_status" => $order_status,
                        "tracking_no" => $tracking_no,
                        "created_at" => $created_at,
                        "user_name" => $user_name,
                        "product_title" => $product_title,
                        "action" => $action
                    );
                }

                if ($arrData->count() > 1000) {
                    $response = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $total,
                        "recordsFiltered" => $totalFilter,
                        "data" => $order_arr,
                        "length" => 1
                    );
                } else {
                    $response = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $total,
                        "recordsFiltered" => $totalFilter,
                        "data" => $order_arr,
                        "length" => 0
                    );
                }

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }

}
