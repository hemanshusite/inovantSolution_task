<?php

namespace App\Http\Requests\Api;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CheckoutApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $cartIds = $this->input('cart_ids');
        
        if (!is_null($cartIds) && !is_array($cartIds)) {
            $this->merge([
                'cart_ids' => [$cartIds]
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'cart_ids' => 'required|array|min:1',
            'cart_ids.*' => [
                'integer',
                function ($attribute, $value, $fail) {
                    $exists = Cart::where('id', $value)
                        ->where('user_id', $this->user_id)
                        ->whereNull('deleted_at')
                        ->exists();
                    
                    if (!$exists) {
                        $fail("The selected cart item {$value} is invalid or does not belong to you.");
                    }
                }
            ]
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => 0,
            'message' => $validator->errors()->all(),
        ]);
        
        throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }
}