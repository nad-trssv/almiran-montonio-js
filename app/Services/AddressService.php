<?php

namespace App\Services;


use App\Http\Requests\PaginateRequest;
use Exception;
use App\Models\Address;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;


class AddressService
{

    public $addressFilter = ['full_name', 'email', 'country_code', 'phone', 'country', 'city', 'state', 'zip_code', 'address', 'web_token'];

    /**
     * @throws Exception
     */
    public function list(PaginateRequest $request)
    {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';
            
            $session_id = $request->cookie('cookies_app');
            if(isset(Auth::user()->id)) {
                $searchBy = 'user_id';
                $searchValue = Auth::user()->id;
            } else {
                $searchBy = 'web_token';
                $searchValue = $session_id;
            }

            return Address::where($searchBy, $searchValue)->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->addressFilter)) {
                        $query->where($key, 'like', '%' . $request . '%');
                    }
                }
            })->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
    
    /**
     * @throws Exception
     */
    public function store(AddressRequest $request)
    {
        $session_id = $request->cookie('cookies_app');
        if(isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
        } else {
            $userId = null;
        }
        try {
            return Address::create($request->validated() + ['user_id' => $userId ] + ['web_token' => $session_id]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(AddressRequest $request, Address $address)
    {
        try {
            return tap($address)->update($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Address $address): void
    {
        try {
            $address->delete();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
