<?php

namespace App\Http\Requests\Api\Stats;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayedTrackRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'track_id' => 'required|integer',
            'server_id' => 'required|integer',
            'user_id' => 'required|integer',
            'release_id' => 'required|integer',
        ];
    }
}
