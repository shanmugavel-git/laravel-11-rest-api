<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests; 

class SaleCampaignController extends Controller
{
    public function index(Request $request)  : JsonResponse	// Json response defined type 
    {
		$items_price =$request->input('items_price');  	// Get the item price provided
		$input_price_arr=explode(',',$items_price);	   	// Explode the comma separated price to array
		rsort($input_price_arr);						// Reverse sorting array ie descending order
		$payable_items = array();						// Initiating payable price array
		$discounted_items = array();  					// Initiating discounted price array
		$count=count($input_price_arr);  				// Count the number of items that provided by user
			
			//  For loop starts
			
			for($i=0;$i<=$count;$i++){					
				if(isset($input_price_arr[$i]) && isset($input_price_arr[$i+1]) ) 		// Checking 2 array values are set or not
				if( $input_price_arr[$i]==$input_price_arr[$i+1]){ 						// Checking 2 array values same or not
					$payable_items[]=$input_price_arr[$i]??$input_price_arr[$i];		// If initial both values are same that will be moved to payable_items array set
					$payable_items[]=$input_price_arr[$i+1]??$input_price_arr[$i+1];  
				}
				else {
					if((count($payable_items)-count($discounted_items))==2){			// If payable_items array length is equal to 2 move the lesser item price to discount
					$discounted_items[]=$input_price_arr[$i]??$input_price_arr[$i]; 
					$discounted_items[]=$input_price_arr[$i+1]??$input_price_arr[$i+1];
					}else  
					{
					$payable_items[]=$input_price_arr[$i]??$input_price_arr[$i];		// if the price of any pair differs, move the higher price to payable and lesser to discount
					$discounted_items[]=$input_price_arr[$i+1]??$input_price_arr[$i+1]; 
					}  
				}
					$i++;																// increase the loop value 
				}
				 
			// For loop ends here	 
			
		return response()->json(['discounted_items'=>$discounted_items,'payable_items'=>$payable_items]); // returning the response in json array format
    } 
   
}

// API ENDS 