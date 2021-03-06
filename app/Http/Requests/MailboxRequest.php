<?php

namespace App\Http\Requests;

use App\Rules\FQDN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailboxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'host' => ['required', new FQDN()],
            'port' => 'required|numeric',
            'encryption' => ['required', Rule::in(['none', 'tls', 'ssl'])]
        ];
    }
}
