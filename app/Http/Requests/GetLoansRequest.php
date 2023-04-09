<?php

namespace App\Http\Requests;

use App\Models\ApiRequest;
use App\Models\FailedValidation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class GetLoansRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'account_number' => ['required', 'numeric', 'digits:10', 'exists:accounts,number']
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->failed()) {
                $apiRequest = ApiRequest::addNew('invalid');
                Log::debug('kk:', $validator->errors()->toArray());
                FailedValidation::create([
                    'api_request_id' => $apiRequest->id,
                    'errors' => json_encode(
                        $validator->errors()->toArray()['account_number'] ?? []
                    )
                ]);
            }
        });
    }

    public function messages(): array
    {
        return [
            'account_number.exists' => 'Account Number does not exist in our records',
        ];
    }
}
