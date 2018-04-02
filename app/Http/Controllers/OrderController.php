<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Transformers\Json;
use App\Order;

class OrderController extends Controller
{
    public function get_data(Request $request)
    {
    	$data = DB::table('orders as a')
    			->where('id_user', $request->input('id_user'))
                ->get();

        $result = new \stdClass;

        $result->orders = $data;

    	if (count($data) > 0) {
	        return response()->json(Json::response(200, 'Successfully load content.', $result, 200));
    	} else {
    		return response()->json(Json::response(404, 'Data is Empty', new class{}, 200));
    	}
    }

    public function delivery(Request $request)
    {
    	$params = [
	    	'reference' => $request->input('reference'),
	    	'type' => $request->input('type'),
	    	'origin_name' => $request->input('origin_name'),
	    	'origin_address' => $request->input('origin_address'),
	    	'destination' => $request->input('destination'),
	    	'contact' => $request->input('contact'),
	    	'id_user' => $request->input('id_user')
	    ];

	    $validator = Validator::make($params, [
            'reference' => 'required',
            'type' => 'required|in:PLA,PAL,PLL',
            'origin_name' => 'required',
            'origin_address' => 'required',
            'destination' => 'required',
            'contact' => 'required',
            'id_user' => 'required'
        ]);

        if ($validator->fails()) {

            $messages = '';
            $i = 0;
            foreach ($validator->errors()->getMessages() as $value) {
                if (count($validator->errors()->getMessages()) > 1 && $i > 0) {
                    $messages .= ' & ';
                }
                $messages .= $value[0];
                $i++;
            }

            return response()->json([
                'status' => 404,
                'message' => $messages,
                'data' => new class{},
            ]);
        }

        $dataInsert = DB::table('orders')->insert(
		    [
		    	'reference' => $params['reference'],
		    	'type' => $params['type'],
		    	'origin_name' => $params['origin_name'],
	            'origin_address' => $params['origin_address'],
	            'destination' => $params['destination'],
	            'contact' => $params['contact'],
	            'id_user' => $params['id_user'],
	            'created_at' => date('Y-m-d')
		    ]
		);

        $result = new \stdClass;

    	return response()->json(Json::response(200, 'Successfully Delivery Order.', $result, 200));
    }
}
