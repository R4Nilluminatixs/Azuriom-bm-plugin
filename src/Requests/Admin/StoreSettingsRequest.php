<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
        ];
    }
}
