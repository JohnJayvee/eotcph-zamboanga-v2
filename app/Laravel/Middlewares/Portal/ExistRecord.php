<?php

namespace App\Laravel\Middlewares\Portal;

use Closure, Helper,Str;
use App\Laravel\Models\{Business, Holiday};


class ExistRecord
{

    protected $reference_id;
    protected $module;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $record
     * @return mixed
     */
    public function handle($request, Closure $next, $record)
    {
        $this->reference_id = $request->id;
        $module = "profile";
        $found_record = true;
        $previous_route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        switch (strtolower($record)) {
            case 'business':
                if(! $this->__exist_business($request)) {
                    $found_record = false;
                    session()->flash('notification-status', "failed");
                    session()->flash('notification-msg', "No record found or resource already removed or you are not authorized to access this resource.");

                    $module = "business.index";
                }
            break;

        }

        if($found_record) {
            return $next($request);
        }
        no_record_found:
        return redirect()->route("web.{$module}");
    }

     private function __exist_business($request){
        $business = Business::find($this->reference_id);
        $auth_id = auth()->guard('customer')->user()->id;
        if($business && $auth_id == $business->customer_id){
            $request->merge(['business_data' => $business]);
            return TRUE;
        }
        return FALSE;
    }

}
