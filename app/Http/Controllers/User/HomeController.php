<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\user;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Order;

class HomeController extends Controller
{

    public function user_view_product(Request $request){
        if(product::where('id', '=', $request->prd_id)->exists()){
            if(product::where('id', '=', $request->prd_id)->exists()){
                $prod_data = product::where('id', '=', $request->prd_id)->get();
                return response()->json([
                    'status'=>200,
                    'prod_data'=>$prod_data,
                ]);
            } else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No such product found'
                ]);
            }
        } else{
            $decryptedData = base64_decode($request->h7khde4rr45c9h);
            if(product::where('id', '=', $decryptedData)->exists()){
                $selected_prod_data = product::where('id', '=', $decryptedData)->get();
                $selected_prod_cate = product::where('id', '=', $decryptedData)->select('category')->first();
                $related_prod_data = product::where('category', '=', $selected_prod_cate['category'])->where('id', '<>', $decryptedData)->get();
                $related_prod_count = product::where('category', '=', $selected_prod_cate['category'])->where('id', '<>', $decryptedData)->count();
                return view('user.product', compact('selected_prod_data', 'related_prod_data', 'related_prod_count'));
            } else{
                return view('user.product')->with('status',"No such product found");
            }
        }
    }

    public function fetch_product_for_user(Request $request){
        if($request->num_of_prod){
            $num_data = $request->num_of_prod;
            $prod_details = product::where('is_active', '=', 'Y')->take(4+$num_data)->get();
            $prod_count = $prod_details->count();
            $total_prod_count = product::where('is_active', '=', 'Y')->count();
            if($num_data < $total_prod_count ){
                return response()->json([
                    'prod_details'=>$prod_details,
                    'prod_count' =>$prod_count,
                ]);
            }else{
                return response()->json([
                    'status'=>604,
                    'message'=>'No more Product Found'
                ]);
            }
        }else{
            if($request->prod_id){
                $prod_details = product::where('id', '=', $request->prod_id)->get();
            } else{
                $prod_details = product::where('is_active', '=', 'Y')->take(4)->get();
            }
            if($prod_details)
            {
                return response()->json([
                    'prod_details'=>$prod_details,
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
    }

    public function view_cart(){
        if(Auth::id()){
            return view('user.cart');
        } else{
            return redirect('login');
        }
    }

    public function add_to_cart(Request $request){
        if(Auth::id()){
            $if_exists = Cart::where('user_id', '=', Auth::id())->where('product_id', '=', $request->prod_id)->get()->toArray();
            if($if_exists){
                return response()->json([
                    'status'=>202,
                    'message'=>'Item Already added to cart'
                ]);
            } else{
                $user = Auth::user();
                $product = Product::find($request->prod_id);
                $cart = new Cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->user_id = $user->id;
                $cart->product_title = $product->title;
                if ($product->discount_price != null){
                    $cart->price = $product->discount_price;
                } else{
                    $cart->price = $product->price;
                }
                $cart->image = $product->image;
                $cart->product_id = $product->id;
                $cart->save();
                return response()->json([
                    'user'=>$user,
                    'message'=>'Product Added to Cart '
                ]);
            }
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'Please Login to Continue'
            ]);
        }
    }

    public function fetch_cart_item(){
        if(Auth::id()){
            $cart_details = Cart::where('user_id', '=', Auth::id())->get()->toArray();
            if($cart_details)
            {
                return response()->json([
                    'cart_details'=>$cart_details,
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'Your cart is empty'
                ]);
            }
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'Please Login to Continue'
            ]);
        }
    }

    public function update_cart_details(Request $request){
        if($request->req_type == 'inc'){
            $avl_prod_qty = Product::where('id', '=', $request->productid)->first(['quantity']);
            if($request->presentval < $avl_prod_qty['quantity']){
                $new_qty = $request->presentval+1;
                $new_price = $request->presentprice+($request->presentprice/$request->presentval);
                $update_cart_details = cart::where('id', '=', $request->cart_itm_id)
                                            ->where('user_id', '=', Auth::id())
                                            ->update(['price' => $new_price,'quantity' => $new_qty]);
                return response()->json([
                    'status'=>200,
                ]);
            }else{
                return response()->json([
                    'message'=>'No more item available',
                ]);
            }
        }

        if($request->req_type == 'dec') {
            if($request->presentval > 1){
                $new_qty = $request->presentval-1;
                $new_price = $request->presentprice-($request->presentprice/$request->presentval);
                $update_cart_details = cart::where('id', '=', $request->cart_itm_id)
                                            ->where('user_id', '=', Auth::id())
                                            ->update(['price' => $new_price,'quantity' => $new_qty]);
                return response()->json([
                    'status'=>200,
                ]);
            }else{
                return response()->json([
                    'message'=>'Quantity can not be less than one',
                ]);
            }
        }

        // if($request->req_type == 'selct-itm') {
        //     // print_r($request->all());die;
        //     if($request->chk == 'checked'){
        //         if($request->present_btn == $request->itm_id){
        //             $new_qty = $request->present_qty+$request->itm_qty;
        //             $new_price = ($request->itm_price*$request->itm_qty)+$request->present_prc;
        //         } else{
        //             $new_qty = $request->present_qty+$request->itm_qty;
        //             $new_price = ($request->itm_price*$request->itm_qty)+$request->present_prc;
        //         }
        //         return response()->json([
        //             'status'=>200,
        //             'itm_id'=>$request->itm_id,
        //             'total_quantity'=>$new_qty,
        //             'total_price'=>$new_price,
        //         ]);
        //     } else {
        //         $new_qty = $request->present_qty-$request->itm_qty;
        //         $new_price = $request->itm_price*$new_qty;
        //         return response()->json([
        //             'status'=>200,
        //             'total_quantity'=>$new_qty,
        //             'total_price'=>$new_price,
        //         ]);
        //     }

        // }
    }

    public function remove_from_cart($id){
        $remove_cart_data = cart::find($id);
        if($remove_cart_data)
        {
            $remove_cart_data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Item Remove Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Item Found.'
            ]);
        }
    }

    public function view_wishlist(){
        if(Auth::id()){
            return view('user.wishlist');
        } else{
            return redirect('login');
        }
    }

    public function add_to_wishlist(Request $request){
        if(Auth::id()){
            if($request->mId){
                $if_exists = Wishlist::where('user_id', '=', Auth::id())->where('product_id', '=', $request->mId)->get()->toArray();
                if($if_exists){
                    return response()->json([
                        'status'=>202,
                        'message'=>'Item Already exist in Wishlist'
                    ]);
                } else{
                    $remove_cart_data = cart::find($request->rId);
                    $remove_cart_data->delete();
                    $user_id = Auth::id();
                    $wishlist = new Wishlist;
                    $wishlist->product_id = $request->mId;
                    $wishlist->user_id = $user_id;
                    $wishlist->save();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Item moved to wishlist'
                    ]);
                }
            }
            $if_exists = Wishlist::where('user_id', '=', Auth::id())->where('product_id', '=', $request->prod_id)->get()->toArray();
            if($if_exists){
                return response()->json([
                    'status'=>202,
                    'message'=>'Item Already exist in Wishlist'
                ]);
            } else{
                $user_id = Auth::id();
                $wishlist = new Wishlist;
                $wishlist->product_id = $request->prod_id;
                $wishlist->user_id = $user_id;
                $wishlist->save();
                return response()->json([
                    'message'=>'Item Added to wishlist '
                ]);
            }
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'Please Login to Continue'
            ]);
        }
    }

    public function fetch_wishlist_item(){
        if(Auth::id()){
            $wishlist = Wishlist::join('products', 'wishlists.product_id', '=', 'products.id')
                                    ->select('products.title', 'products.image', 'products.category', 'wishlists.id','wishlists.product_id', 'wishlists.created_at')
                                    ->where('user_id', '=', Auth::id())
                                    ->get();
            if($wishlist ->count() > 0)
            {
                return response()->json([
                    'status'=>200,
                    'wishlist_details'=>$wishlist
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>400,
                    'message'=>'Your wishlist is empty'
                ]);
            }
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'Please Login to Continue'
            ]);
        }
    }

    public function remove_from_wishlist($id){
        $remove_wishlist_data = Wishlist::find($id);
        if($remove_wishlist_data)
        {
            $remove_wishlist_data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Item Removed Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Item Found.'
            ]);
        }
    }

    public function count_wish_cart_item(){
        if(Auth::id()){
            $wish_item = Wishlist::where('user_id', '=', Auth::id())->count();
            $cart_item = Cart::where('user_id', '=', Auth::id())->count();

            return response()->json([
                'status'=>200,
                'total_wish_item'=>$wish_item,
                'total_cart_item'=>$cart_item
            ]);
        } else{
            $wish_item = 0;
            $cart_item = 0;

            return response()->json([
                'status'=>404,
                'total_wish_item'=>$wish_item,
                'total_cart_item'=>$cart_item
            ]);
        }

    }

    public function view_checkout(Request $request){
        if(Auth::id()){
            $ids_string = $request->input('hg67ghcf');
            if($request->input('hg67ghcf') && $request->input('shdyw2ji') && $request->input('hd53wsdp')){
                $total_item = base64_decode($request->input('shdyw2ji'));
                $total_price = base64_decode($request->input('hd53wsdp'));
                $cartItems = Cart::where('user_id', Auth::id())->get();
                return view('user.checkout', compact('cartItems', 'ids_string', 'total_item', 'total_price'));
            } else{
                return redirect('cart');
            }
        } else{
            return redirect('login');
        }
    }

    // public function convertLatLngToAddress($lat, $lng)
    // {
    //     $client = new Client();
    //     $apiKey = 'your-api-key-goes-here';
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$apiKey";
    //     $response = $client->request('GET', $url);
    //     $result = json_decode($response->getBody());
    //     print($result->status);

    //     if ($result->status == 'OK') {
    //         return $result->results[0]->formatted_address;
    //     } else {
    //         return null;
    //     }
    // }

    public function get_address(Request $request){
        // print_r($request->all());
        // $lat = $request->latitude;
        // $lng = $request->longitude;
        // $address = $this->convertLatLngToAddress($lat, $lng);
        // return $address;
        $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $request->latitude,
            'lon' => $request->longitude,
            'zoom' => 18,
        ]);

        if ($response->ok()) {
            $data = $response->json();
            $address = $data['display_name'];
            return response()->json([
                'status'=>200,
                'data'=>$data,
                'address'=>$address
            ]);
        } else {
            return response()->json([
                'status'=>404,
            ]);
        }
        // print_r($address);
    }

    public function placeOrder(Request $request){
        // print_r($request->all());die;
        $orderItems = Cart::select('price', 'quantity', 'product_id')->where('user_id', Auth::id())->get();
        $ids = explode(',', $request->prodIds);
        $productIds = [];
        $orderIds = [];
        foreach ($orderItems as $item) {
            $productIds[] = $item->product_id;
        }
        foreach($ids as $id) {
            $orderIds[] = base64_decode($id);
        }
        // Find the difference between $productIds and $orderIds using array_diff()
        $difference = array_diff($productIds, $orderIds);

        if (empty($difference)) {
            // All values in $productIds exist in $orderIds, now insert all orders
            $usr_Id = Auth::id();
            foreach ($orderItems as $item) {
                $placeOrders = new Order;
                $placeOrders->user_id = $usr_Id;
                $placeOrders->product_id = $item->product_id;
                $placeOrders->product_qty = $item->quantity;
                $placeOrders->product_prc = $item->price;
                $placeOrders->bill_name = $request->name;
                $placeOrders->bill_Phone = $request->phone;
                $placeOrders->bill_email = $request->email;
                $placeOrders->country = $request->country;
                $placeOrders->state = $request->state;
                $placeOrders->city = $request->city;
                $placeOrders->address1 = $request->address1;
                $placeOrders->address2 = $request->address2;
                $placeOrders->pin_code = $request->pin;
                $placeOrders->payment_mode = $request->pay_method;
                if($request->pay_method == 'cod'){
                    $placeOrders->payment_id = '0';
                } else{
                    $placeOrders->payment_id = '1';

                }
                $placeOrders->order_status = 'pending';
                $randStr = Str::random(10);
                $trackingCode = $randStr . '-' . $usr_Id;
                $placeOrders->tracking_no = $trackingCode;
                $placeOrders->save();
            }
            //After data was saved successfully then delete data from cart table
            $remove_cart_data = Cart::where('user_id', '=', $usr_Id)->delete();
            if($remove_cart_data){
                return response()->json([
                    'status'=>200,
                    'message'=>'Order Placed Successfully.'
                ]);
            } else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Order Placed Failed.'
                ]);
            }
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'There is an error !!'
            ]);
        }
    }

    public function view_contact(){
        return view('user.contact');
    }

    public function view_shop(){
        return view('user.shop');
    }
}
